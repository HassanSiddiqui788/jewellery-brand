<?php
/**
 * Site Configuration & Global Helpers
 * Bijoux Jewelry Store
 */

if (!defined('BIJOUX_APP')) {
    define('BIJOUX_APP', true);
}

// Site Details
if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'Bijoux');
}
if (!defined('SITE_TAGLINE')) {
    define('SITE_TAGLINE', 'Artisan Handcrafted Jewelry');
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
function e($string) {
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}
