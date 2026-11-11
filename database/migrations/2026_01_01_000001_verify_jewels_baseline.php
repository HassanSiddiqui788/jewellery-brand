<?php

declare(strict_types=1);

use Core\Database\Connection;

/**
 * Non-destructive Phase 1 baseline migration.
 * Preserves existing jewels_db tables (categories, products, etc.) without dropping or duplicating tables.
 */
return [
    'up' => static function (\PDO $pdo, Connection $connection): void {
        // Verify schema accessibility non-destructively while keeping existing tables intact
        $pdo->query('SELECT 1');
    },
    'down' => static function (\PDO $pdo, Connection $connection): void {
        // Non-destructive baseline check requires no destructive table drops
    },
];

