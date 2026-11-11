<?php
/**
 * Site Configuration & Global Helpers
 * Lorem Ipsum Store (Backward-Compatible Bridge to bootstrap/app.php)
 */

if (!defined('LOREM_APP')) {
    define('LOREM_APP', true);
}
if (!defined('BIJOUX_APP')) {
    define('BIJOUX_APP', true);
}

// Initialize Core Application Container, Environment, Logging, and Session Infrastructure
require_once __DIR__ . '/../bootstrap/app.php';
$__legacyApp = app_bootstrap(PHP_SAPI !== 'cli');
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    $__legacyApp->session()->start();
}

// Site Details (backed by .env / config/app.php with legacy defaults)
if (!defined('SITE_NAME')) {
    define('SITE_NAME', (string) $__legacyApp->config()->get('app.name', 'Lorem Ipsum'));
}
if (!defined('SITE_TAGLINE')) {
    define('SITE_TAGLINE', (string) $__legacyApp->config()->get('app.tagline', 'Lorem Ipsum Dolor Sit Amet'));
}

/**
 * Returns a sanitized URL relative to current page base_path
 *
 * @param string $path
 * @param string|null $base
 * @return string
 */
function site_url($path = '', $base = null) {
    global $base_path;
    $b = $base !== null ? $base : ($base_path ?? './');
    $clean_path = ltrim($path, '/');
    return $b . $clean_path;
}

/**
 * Returns an asset path relative to current page base_path
 *
 * @param string $asset_path
 * @param string|null $base
 * @return string
 */
function asset_url($asset_path, $base = null) {
    return site_url('assets/' . ltrim($asset_path, '/'), $base);
}

/**
 * Returns clean escaped HTML
 *
 * @param string $string
 * @return string
 */
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars((string) $string, ENT_QUOTES, 'UTF-8');
    }
}

// Global Database Connection (MySQLi backward-compatibility bridge)
if (file_exists(__DIR__ . '/../config/db.php')) {
    require_once __DIR__ . '/../config/db.php';
}
