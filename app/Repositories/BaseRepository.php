<?php

declare(strict_types=1);

namespace App\Repositories;

use Core\Database\Connection;

/**
 * Base PDO repository providing typed access to the shared database connection.
 */
abstract class BaseRepository
{
    public function __construct(protected readonly Connection $connection)
    {
    }

    /**
     * @param array<int|string, mixed> $params
     * @return list<array<string, mixed>>
     */
    protected function fetchAll(string $sql, array $params = []): array
    {
        return $this->connection->fetchAll($sql, $params);
    }

    /**
     * @param array<int|string, mixed> $params
     * @return array<string, mixed>|null
     */
    protected function fetchOne(string $sql, array $params = []): ?array
    {
        return $this->connection->fetchOne($sql, $params);
    }
}

