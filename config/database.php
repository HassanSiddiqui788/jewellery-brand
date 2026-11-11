<?php

declare(strict_types=1);

return [
    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => (string) env('DB_HOST', 'localhost'),
            'port' => (int) env('DB_PORT', 3306),
            'database' => (string) env('DB_DATABASE', 'jewels_db'),
            'username' => (string) env('DB_USERNAME', 'root'),
            'password' => (string) env('DB_PASSWORD', ''),
            'charset' => (string) env('DB_CHARSET', 'utf8mb4'),
            'collation' => (string) env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false,
            ],
        ],
    ],
];

