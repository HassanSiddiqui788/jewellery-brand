<?php

declare(strict_types=1);

return [
    'driver' => (string) env('SESSION_DRIVER', 'file'),
    'name' => (string) env('SESSION_NAME', 'bijoux_session'),
    'lifetime' => max(1, (int) env('SESSION_LIFETIME', 120)), // minutes
    'path' => (string) env('SESSION_PATH', '/'),
    'domain' => (string) env('SESSION_DOMAIN', ''),
    'secure' => env('SESSION_COOKIE_SECURE', 'auto'), // true | false | 'auto'
    'http_only' => filter_var(env('SESSION_COOKIE_HTTPONLY', true), FILTER_VALIDATE_BOOLEAN),
    'same_site' => (string) env('SESSION_COOKIE_SAMESITE', 'Lax'),
    'use_strict_mode' => true,
    'use_only_cookies' => true,
];

