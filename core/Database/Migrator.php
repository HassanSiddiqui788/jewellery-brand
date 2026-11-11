<?php

declare(strict_types=1);

namespace Core\Database;

/**
 * Non-destructive database schema migration manager tracking applied versions in schema_migrations.
 */
final class Migrator
{
    public function __construct(
        private readonly Connection $connection,
        private readonly string $migrationsPath
    ) {
    }

    public function ensureMigrationsTable(): void
    {
        $driver = $this->connection->pdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if ($driver === 'mysql') {
            $sql = <<<'SQL'
                CREATE TABLE IF NOT EXISTS `schema_migrations` (
                    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    `migration` VARCHAR(255) NOT NULL,
                    `batch` INT UNSIGNED NOT NULL,
                    `executed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `uq_schema_migrations_name` (`migration`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            SQL;
        } else {
            $sql = <<<'SQL'
                CREATE TABLE IF NOT EXISTS schema_migrations (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    migration VARCHAR(255) NOT NULL UNIQUE,
                    batch INTEGER NOT NULL,
                    executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            SQL;
        }

        $this->connection->pdo()->exec($sql);
    }

    /**
     * @return list<string>
     */
    public function discoverMigrationFiles(): array
    {
        if (!is_dir($this->migrationsPath)) {
            return [];
        }

        $files = glob(rtrim($this->migrationsPath, '/\\') . '/*.php');
        if ($files === false) {
            return [];
        }

        sort($files, SORT_STRING);
        return array_values($files);
    }

    /**
     * @return list<string>
     */
    public function getAppliedMigrations(): array
    {
        $this->ensureMigrationsTable();
        $rows = $this->connection->fetchAll('SELECT migration FROM schema_migrations ORDER BY id ASC');

        return array_map(static fn (array $row): string => (string) $row['migration'], $rows);
    }

    /**
     * @return list<string> Names of newly executed migrations
     */
    public function migrate(): array
    {
        $this->ensureMigrationsTable();

        $applied = array_flip($this->getAppliedMigrations());
        $files = $this->discoverMigrationFiles();
        $batch = $this->getNextBatchNumber();
        $executed = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            if (isset($applied[$name])) {
                continue;
            }

            $migration = require $file;
            if (!is_array($migration) || !isset($migration['up']) || !is_callable($migration['up'])) {
                throw new \RuntimeException(sprintf('Invalid migration structure in %s', $name));
            }

            // MySQL implicitly commits DDL statements; avoid wrapping DDL inside active transactions when using MySQL
            $driver = $this->connection->pdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);
            if ($driver === 'mysql') {
                ($migration['up'])($this->connection->pdo(), $this->connection);
                $this->recordMigration($name, $batch);
            } else {
                $this->connection->transaction(function (Connection $conn) use ($migration, $name, $batch): void {
                    ($migration['up'])($conn->pdo(), $conn);
                    $this->recordMigration($name, $batch);
                });
            }

            $executed[] = $name;
        }

        return $executed;
    }

    /**
     * @return list<string> Names of rolled back migrations from the latest batch
     */
    public function rollbackLastBatch(): array
    {
        $this->ensureMigrationsTable();

        $latest = $this->connection->fetchOne('SELECT MAX(batch) AS max_batch FROM schema_migrations');
        $lastBatch = (int) ($latest['max_batch'] ?? 0);
        if ($lastBatch <= 0) {
            return [];
        }

        $rows = $this->connection->fetchAll(
            'SELECT migration FROM schema_migrations WHERE batch = :batch ORDER BY id DESC',
            [':batch' => $lastBatch]
        );

        $rolledBack = [];
        foreach ($rows as $row) {
            $name = (string) $row['migration'];
            $file = rtrim($this->migrationsPath, '/\\') . '/' . $name . '.php';
            if (is_file($file)) {
                $migration = require $file;
                if (is_array($migration) && isset($migration['down']) && is_callable($migration['down'])) {
                    ($migration['down'])($this->connection->pdo(), $this->connection);
                }
            }

            $this->connection->execute('DELETE FROM schema_migrations WHERE migration = :name', [':name' => $name]);
            $rolledBack[] = $name;
        }

        return $rolledBack;
    }

    /**
     * @return array<int, array{migration:string, applied:bool}>
     */
    public function status(): array
    {
        $applied = array_flip($this->getAppliedMigrations());
        $result = [];

        foreach ($this->discoverMigrationFiles() as $file) {
            $name = basename($file, '.php');
            $result[] = [
                'migration' => $name,
                'applied' => isset($applied[$name]),
            ];
        }

        return $result;
    }

    private function getNextBatchNumber(): int
    {
        $row = $this->connection->fetchOne('SELECT COALESCE(MAX(batch), 0) AS current_batch FROM schema_migrations');
        return ((int) ($row['current_batch'] ?? 0)) + 1;
    }

    private function recordMigration(string $name, int $batch): void
    {
        $this->connection->execute(
            'INSERT INTO schema_migrations (migration, batch) VALUES (:migration, :batch)',
            [':migration' => $name, ':batch' => $batch]
        );
    }
}

