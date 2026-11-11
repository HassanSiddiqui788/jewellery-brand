<?php

declare(strict_types=1);

namespace Tests\Unit;

use Core\Config\ConfigRepository;
use Core\Database\Connection;
use Core\Database\Migrator;
use Core\Exceptions\DatabaseConnectionException;
use Core\Logging\Logger;
use Tests\Assert;

final class DatabaseLayerTest
{
    public function testSharedConnectionReuse(): void
    {
        Connection::resetSharedInstance();
        $config = ConfigRepository::loadFromPath(BASE_PATH . '/config');
        $connA = Connection::fromConfig($config);
        $connB = Connection::fromConfig($config);

        Assert::same($connA, $connB, 'Connection::fromConfig must return one shared instance.');
        Connection::resetSharedInstance();
    }

    public function testDatabaseConnectionExceptionDoesNotLeakCredentials(): void
    {
        $tmpLog = sys_get_temp_dir() . '/bijoux_db_test_' . bin2hex(random_bytes(4)) . '.log';
        $logger = new Logger($tmpLog, 'debug');
        $secretPassword = 'UltraSecretPassword!999';

        $badConn = new Connection([
            'host' => '127.0.0.1',
            'port' => 65431,
            'database' => 'jewels_db',
            'username' => 'bad_user',
            'password' => $secretPassword,
            'charset' => 'utf8mb4',
        ], $logger);

        try {
            $thrown = Assert::throws(DatabaseConnectionException::class, static function () use ($badConn): void {
                $badConn->pdo();
            });

            Assert::notContains($secretPassword, $thrown->getMessage());
            Assert::notContains('bad_user', $thrown->getMessage());

            if (is_file($tmpLog)) {
                $logContent = (string) file_get_contents($tmpLog);
                Assert::notContains($secretPassword, $logContent);
            }
        } finally {
            @unlink($tmpLog);
        }
    }

    public function testMigratorDiscoversBaselineMigration(): void
    {
        $config = ConfigRepository::loadFromPath(BASE_PATH . '/config');
        $conn = Connection::fromConfig($config);
        $migrator = new Migrator($conn, BASE_PATH . '/database/migrations');

        $files = $migrator->discoverMigrationFiles();
        Assert::true(count($files) >= 1, 'Expected at least 1 migration file.');
        Assert::contains('2026_01_01_000001_verify_jewels_baseline.php', $files[0]);
    }

    public function testLiveMysqlPdoConnectivityIfReachable(): void
    {
        $config = ConfigRepository::loadFromPath(BASE_PATH . '/config');
        $conn = new Connection((array) $config->get('database.connections.mysql', []));

        if (!$conn->ping()) {
            Assert::skip('MySQL daemon is not reachable on localhost/127.0.0.1:3306 in this environment.');
        }

        $row = $conn->fetchOne('SELECT 1 AS alive');
        Assert::same(1, (int) ($row['alive'] ?? 0));
    }
}

