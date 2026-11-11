#!/usr/bin/env php
<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

/** @var \Core\Application $app */
$app = require dirname(__DIR__) . '/bootstrap/app.php';

$command = $argv[1] ?? 'status';
$migrator = $app->migrator();

try {
    switch ($command) {
        case 'status':
            $rows = $migrator->status();
            echo "Migration Status:\n";
            if ($rows === []) {
                echo "  (no migration files found)\n";
                exit(0);
            }
            foreach ($rows as $row) {
                $flag = $row['applied'] ? 'APPLIED' : 'PENDING';
                echo sprintf("  [%s] %s\n", $flag, $row['migration']);
            }
            exit(0);

        case 'up':
            $executed = $migrator->migrate();
            if ($executed === []) {
                echo "Nothing to migrate. Database schema is up to date.\n";
            } else {
                foreach ($executed as $name) {
                    echo "Migrated: {$name}\n";
                }
            }
            exit(0);

        case 'rollback':
            $rolledBack = $migrator->rollbackLastBatch();
            if ($rolledBack === []) {
                echo "Nothing to roll back.\n";
            } else {
                foreach ($rolledBack as $name) {
                    echo "Rolled back: {$name}\n";
                }
            }
            exit(0);

        default:
            fwrite(STDERR, "Unknown command '{$command}'. Use: status | up | rollback\n");
            exit(1);
    }
} catch (\Throwable $e) {
    $app->logger()->exception($e, ['cli_command' => $command]);
    fwrite(STDERR, 'Migration failed: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}

