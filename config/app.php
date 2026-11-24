<?php

declare(strict_types=1);

return [
    'name' => env('APP_NAME', 'JARWAYA JEWELS'),
    'tagline' => env('APP_TAGLINE', 'Exquisite Fine Jewellery & Modern Heirlooms'),
    'env' => env('APP_ENV', 'production'),
    'debug' => filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN),
    'url' => rtrim((string) env('APP_URL', 'http://localhost'), '/'),
    'timezone' => env('APP_TIMEZONE', 'UTC'),
    'currency' => env('APP_CURRENCY', 'PKR'),
    'currency_symbol' => env('APP_CURRENCY_SYMBOL', 'Rs.'),

    'paths' => [
        'root' => BASE_PATH,
        'app' => BASE_PATH . '/app',
        'config' => BASE_PATH . '/config',
        'core' => BASE_PATH . '/core',
        'database' => BASE_PATH . '/database',
        'public' => BASE_PATH . '/public',
        'resources' => BASE_PATH . '/resources',
        'views' => BASE_PATH . '/resources/views',
        'routes' => BASE_PATH . '/routes',
        'storage' => BASE_PATH . '/storage',
        'logs' => BASE_PATH . '/storage/logs',
        'cache' => BASE_PATH . '/storage/cache',
        'uploads' => BASE_PATH . '/storage/uploads',
    ],

    'logging' => [
        'channel' => env('LOG_CHANNEL', 'single'),
        'level' => env('LOG_LEVEL', 'warning'),
        'path' => BASE_PATH . '/storage/logs/app.log',
    ],
];
