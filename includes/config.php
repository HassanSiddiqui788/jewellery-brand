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
if (!defined('JARWAYA_APP')) {
    define('JARWAYA_APP', true);
}

// Initialize Core Application Container, Environment, Logging, and Session Infrastructure
require_once __DIR__ . '/../bootstrap/app.php';
$__legacyApp = app_bootstrap(PHP_SAPI !== 'cli');
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    $__legacyApp->session()->start();
}

// Site Details (backed by .env / config/app.php with legacy defaults)
if (!defined('SITE_NAME')) {
    define('SITE_NAME', (string) $__legacyApp->config()->get('app.name', 'JARWAYA JEWELS'));
}
if (!defined('SITE_TAGLINE')) {
    define('SITE_TAGLINE', (string) $__legacyApp->config()->get('app.tagline', 'Exquisite Fine Jewellery & Modern Heirlooms'));
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

/**
 * Format currency amount for Pakistan (PKR)
 */
if (!function_exists('format_price')) {
    function format_price(float|int|string $amount, bool $showCents = false): string {
        $symbol = (string) (function_exists('config') ? config('app.currency_symbol', 'Rs.') : 'Rs.');
        $formatted = $showCents ? number_format((float) $amount, 2) : number_format((float) $amount);
        return trim($symbol) . ' ' . $formatted;
    }
}

/**
 * Fetch active products dynamically from MySQL database via CatalogService
 *
 * @param string|null $categorySlug
 * @param int $limit
 * @return list<\App\Models\Product>
 */
if (!function_exists('get_catalog_products')) {
    function get_catalog_products(?string $categorySlug = null, int $limit = 24): array {
        try {
            $app = \Core\Application::getInstance();
            if ($app) {
                /** @var \App\Services\CatalogService $service */
                $service = $app->make(\App\Services\CatalogService::class);
                $filters = ['limit' => $limit];
                if ($categorySlug !== null && $categorySlug !== '') {
                    $filters['category'] = $categorySlug;
                }
                $result = $service->browseProducts($filters);
                return $result['products'] ?? [];
            }
        } catch (\Throwable $e) {
            if (function_exists('app_logger')) {
                app_logger()->warning('CatalogService product fetch failed', ['error' => $e->getMessage()]);
            }
        }
        return [];
    }
}

/**
 * Fetch active categories dynamically from MySQL database via CatalogService
 *
 * @return list<\App\Models\Category>
 */
if (!function_exists('get_catalog_categories')) {
    function get_catalog_categories(): array {
        try {
            $app = \Core\Application::getInstance();
            if ($app) {
                /** @var \App\Services\CatalogService $service */
                $service = $app->make(\App\Services\CatalogService::class);
                return $service->listCategories();
            }
        } catch (\Throwable $e) {
            if (function_exists('app_logger')) {
                app_logger()->warning('CatalogService category fetch failed', ['error' => $e->getMessage()]);
            }
        }
        return [];
    }
}

/**
 * Fetch a single product by slug from MySQL database
 */
if (!function_exists('get_catalog_product_by_slug')) {
    function get_catalog_product_by_slug(string $slug): ?\App\Models\Product {
        try {
            $app = \Core\Application::getInstance();
            if ($app) {
                /** @var \App\Services\CatalogService $service */
                $service = $app->make(\App\Services\CatalogService::class);
                return $service->getProductBySlug($slug);
            }
        } catch (\Throwable $e) {
            // Not found or error
        }
        return null;
    }
}
