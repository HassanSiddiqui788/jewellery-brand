<?php

declare(strict_types=1);

namespace Core\Database;

use Core\Config\ConfigRepository;
use Core\Exceptions\DatabaseConnectionException;
use Core\Logging\Logger;

/**
 * Reusable single-connection PDO database wrapper supporting prepared statements,
 * nested-safe transactions, exception safety, and localhost TCP fallback.
 */
final class Connection
{
    private static ?self $sharedInstance = null;

    private ?\PDO $pdo = null;
    private int $transactionDepth = 0;

    /** @var array<string, mixed> */
    private array $config;
    private ?Logger $logger;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config, ?Logger $logger = null, ?\PDO $existingPdo = null)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->pdo = $existingPdo;
    }

    public static function fromConfig(ConfigRepository $config, ?Logger $logger = null): self
    {
        if (self::$sharedInstance instanceof self) {
            return self::$sharedInstance;
        }

        $defaultConn = (string) $config->get('database.default', 'mysql');
        $connConfig = (array) $config->get('database.connections.' . $defaultConn, []);

        self::$sharedInstance = new self($connConfig, $logger);
        return self::$sharedInstance;
    }

    public static function setSharedInstance(?self $instance): void
    {
        self::$sharedInstance = $instance;
    }

    public static function resetSharedInstance(): void
    {
        self::$sharedInstance = null;
    }

    public function pdo(): \PDO
    {
        if ($this->pdo instanceof \PDO) {
            return $this->pdo;
        }

        $host = (string) ($this->config['host'] ?? 'localhost');
        $port = (int) ($this->config['port'] ?? 3306);
        $database = (string) ($this->config['database'] ?? 'jewels_db');
        $username = (string) ($this->config['username'] ?? 'root');
        $password = (string) ($this->config['password'] ?? '');
        $charset = (string) ($this->config['charset'] ?? 'utf8mb4');
        $collation = (string) ($this->config['collation'] ?? 'utf8mb4_unicode_ci');

        $options = (array) ($this->config['options'] ?? []);
        $options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;
        $options[\PDO::ATTR_DEFAULT_FETCH_MODE] = \PDO::FETCH_ASSOC;
        $options[\PDO::ATTR_EMULATE_PREPARES] = false;

        try {
            $dsn = $this->buildMysqlDsn($host, $port, $database, $charset);
            $this->pdo = new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException $primaryException) {
            // If Unix socket for 'localhost' fails on Ubuntu/XAMPP, retry once via TCP 127.0.0.1
            if ($host === 'localhost') {
                try {
                    $tcpDsn = $this->buildMysqlDsn('127.0.0.1', $port, $database, $charset);
                    $this->pdo = new \PDO($tcpDsn, $username, $password, $options);
                } catch (\PDOException $fallbackException) {
                    $this->logDatabaseFailure($fallbackException);
                    throw new DatabaseConnectionException(
                        'Unable to connect to the MySQL database.',
                        (int) $fallbackException->getCode(),
                        $fallbackException
                    );
                }
            } else {
                $this->logDatabaseFailure($primaryException);
                throw new DatabaseConnectionException(
                    'Unable to connect to the MySQL database.',
                    (int) $primaryException->getCode(),
                    $primaryException
                );
            }
        }

        if ($this->pdo->getAttribute(\PDO::ATTR_DRIVER_NAME) === 'mysql') {
            $this->pdo->exec(sprintf("SET NAMES '%s' COLLATE '%s'", $charset, $collation));
        }

        return $this->pdo;
    }

    public function isConnected(): bool
    {
        return $this->pdo instanceof \PDO;
    }

    public function ping(): bool
    {
        try {
            $stmt = $this->pdo()->query('SELECT 1');
            return $stmt !== false;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Prepare and execute a parameterized SQL statement safely.
     *
     * @param array<int|string, mixed> $params
     */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        try {
            $stmt = $this->pdo()->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            $this->logDatabaseFailure($e, ['sql' => $sql]);
            throw $e;
        }
    }

    /**
     * @param array<int|string, mixed> $params
     * @return array<string, mixed>|null
     */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        $row = $this->query($sql, $params)->fetch();
        return is_array($row) ? $row : null;
    }

    /**
     * @param array<int|string, mixed> $params
     * @return list<array<string, mixed>>
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $rows = $this->query($sql, $params)->fetchAll();
        return is_array($rows) ? array_values($rows) : [];
    }

    /**
     * @param array<int|string, mixed> $params
     */
    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function lastInsertId(): string
    {
        return $this->pdo()->lastInsertId();
    }

    public function beginTransaction(): void
    {
        $pdo = $this->pdo();

        if ($this->transactionDepth === 0) {
            $pdo->beginTransaction();
        } else {
            $pdo->exec('SAVEPOINT sp_level_' . $this->transactionDepth);
        }

        $this->transactionDepth++;
    }

    public function commit(): void
    {
        if ($this->transactionDepth === 0) {
            return;
        }

        $this->transactionDepth--;
        if ($this->transactionDepth === 0) {
            $this->pdo()->commit();
        } else {
            $this->pdo()->exec('RELEASE SAVEPOINT sp_level_' . $this->transactionDepth);
        }
    }

    public function rollBack(): void
    {
        if ($this->transactionDepth === 0) {
            return;
        }

        $this->transactionDepth--;
        if ($this->transactionDepth === 0) {
            if ($this->pdo()->inTransaction()) {
                $this->pdo()->rollBack();
            }
        } else {
            $this->pdo()->exec('ROLLBACK TO SAVEPOINT sp_level_' . $this->transactionDepth);
        }
    }

    /**
     * Execute work inside a database transaction with automatic commit/rollback.
     *
     * @template T
     * @param callable(self): T $callback
     * @return T
     */
    public function transaction(callable $callback): mixed
    {
        $this->beginTransaction();

        try {
            $result = $callback($this);
            $this->commit();
            return $result;
        } catch (\Throwable $e) {
            $this->rollBack();
            throw $e;
        }
    }

    private function buildMysqlDsn(string $host, int $port, string $database, string $charset): string
    {
        return sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $host, $port, $database, $charset);
    }

    /**
     * @param array<string, mixed> $extra
     */
    private function logDatabaseFailure(\Throwable $exception, array $extra = []): void
    {
        if ($this->logger instanceof Logger) {
            $this->logger->exception($exception, $extra);
        }
    }
}

