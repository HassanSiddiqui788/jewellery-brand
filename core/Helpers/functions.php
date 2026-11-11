<?php

declare(strict_types=1);

use Core\Config\EnvLoader;
use Core\Helpers\Security;

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return EnvLoader::get($key, $default);
    }
}

if (!function_exists('base_path')) {
    function base_path(string $relativePath = ''): string
    {
        $root = defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 2);
        if ($relativePath === '') {
            return $root;
        }
        return $root . '/' . ltrim($relativePath, '/\\');
    }
}

if (!function_exists('storage_path')) {
    function storage_path(string $relativePath = ''): string
    {
        return base_path('storage' . ($relativePath !== '' ? '/' . ltrim($relativePath, '/\\') : ''));
    }
}

if (!function_exists('config')) {
    function config(?string $key = null, mixed $default = null): mixed
    {
        $repo = $GLOBALS['__app_config'] ?? null;
        if (!$repo instanceof \Core\Config\ConfigRepository) {
            return $key === null ? [] : $default;
        }
        if ($key === null) {
            return $repo->all();
        }
        return $repo->get($key, $default);
    }
}

if (!function_exists('app_logger')) {
    function app_logger(): \Core\Logging\Logger
    {
        $logger = $GLOBALS['__app_logger'] ?? null;
        if ($logger instanceof \Core\Logging\Logger) {
            return $logger;
        }

        $fallback = new \Core\Logging\Logger(storage_path('logs/app.log'), 'debug');
        $GLOBALS['__app_logger'] = $fallback;
        return $fallback;
    }
}

if (!function_exists('e')) {
    function e(mixed $string): string
    {
        return Security::escapeHtml($string);
    }
}

if (!function_exists('esc_attr')) {
    function esc_attr(mixed $value): string
    {
        return Security::escapeAttr($value);
    }
}

if (!function_exists('esc_url')) {
    function esc_url(string $url): string
    {
        return Security::escapeUrl($url);
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        $session = $GLOBALS['__app_session'] ?? null;
        if ($session instanceof \Core\Session\SessionManager) {
            return $session->csrfToken();
        }
        return '';
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . esc_attr(csrf_token()) . '">';
    }
}

