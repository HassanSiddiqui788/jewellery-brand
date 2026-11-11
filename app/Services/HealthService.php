<?php

declare(strict_types=1);

namespace App\Services;

use Core\Config\ConfigRepository;
use Core\Database\Connection;

/**
 * Provides safe, credential-free system & database readiness diagnostics.
 */
final class HealthService
{
    public function __construct(
        private readonly ConfigRepository $config,
        private readonly Connection $connection
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function snapshot(): array
    {
        $dbConnected = false;
        $tableCount = null;
        $dbDriver = (string) $this->config->get('database.default', 'mysql');

        try {
            $dbConnected = $this->connection->ping();
            if ($dbConnected) {
                $tables = $this->connection->fetchAll('SHOW TABLES');
                $tableCount = count($tables);
            }
        } catch (\Throwable) {
            $dbConnected = false;
        }

        return [
            'status' => $dbConnected ? 'healthy' : 'degraded',
            'application' => [
                'name' => (string) $this->config->get('app.name', 'Lorem Ipsum'),
                'env' => (string) $this->config->get('app.env', 'production'),
                'timezone' => (string) $this->config->get('app.timezone', 'UTC'),
                'currency' => (string) $this->config->get('app.currency', 'PKR'),
                'php_version' => PHP_VERSION,
            ],
            'database' => [
                'driver' => $dbDriver,
                'database' => (string) $this->config->get('database.connections.' . $dbDriver . '.database', 'jewels_db'),
                'connected' => $dbConnected,
                'tables_count' => $tableCount,
            ],
            'timestamp' => gmdate('c'),
        ];
    }
}

