<?php
/**
 * Admin Panel Configuration & Helpers
 * Lorem Ipsum Luxury Jewellery Store — Admin Studio
 *
 * NOTE: Designed as a self-contained admin UI layer matching the storefront
 * theme. Does not open or override the database connection; sample preview
 * data is loaded strictly from admin/data/sample-data.php.
 */

if (!defined('ADMIN_APP')) {
    define('ADMIN_APP', true);
}

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
$__adminCoreApp = app_bootstrap(PHP_SAPI !== 'cli');
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    $__adminCoreApp->session()->start();
}

if (!defined('ADMIN_SITE_NAME')) {
    define('ADMIN_SITE_NAME', 'LOREM');
}

if (!defined('ADMIN_BRAND_SUBTITLE')) {
    define('ADMIN_BRAND_SUBTITLE', 'Atelier Admin');
}

// Navigation structure for the Admin Sidebar (9 core sections)
function get_admin_nav_items() {
    return [
        [
            'id'    => 'dashboard',
            'label' => 'Dashboard',
            'href'  => 'index.php',
            'icon'  => 'fas fa-th-large',
        ],
        [
            'id'    => 'products',
            'label' => 'Products',
            'href'  => 'products.php',
            'icon'  => 'fas fa-gem',
        ],
        [
            'id'    => 'categories',
            'label' => 'Categories',
            'href'  => 'categories.php',
            'icon'  => 'fas fa-tags',
        ],
        [
            'id'    => 'orders',
            'label' => 'Orders',
            'href'  => 'orders.php',
            'icon'  => 'fas fa-shopping-bag',
            'badge' => '3',
        ],
        [
            'id'    => 'customers',
            'label' => 'Customers',
            'href'  => 'customers.php',
            'icon'  => 'fas fa-users',
        ],
        [
            'id'    => 'inventory',
            'label' => 'Inventory',
            'href'  => 'inventory.php',
            'icon'  => 'fas fa-boxes',
            'badge' => '4',
            'badge_type' => 'warning',
        ],
        [
            'id'    => 'messages',
            'label' => 'Messages',
            'href'  => 'messages.php',
            'icon'  => 'fas fa-envelope',
            'badge' => '2',
        ],
        [
            'id'    => 'settings',
            'label' => 'Settings',
            'href'  => 'settings.php',
            'icon'  => 'fas fa-cog',
        ],
        [
            'id'    => 'logout',
            'label' => 'Logout',
            'href'  => 'logout.php',
            'icon'  => 'fas fa-sign-out-alt',
            'divider_before' => true,
        ],
    ];
}

/**
 * Safely escape output for HTML rendering
 */
function e_admin($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

/**
 * Format currency nicely for display
 */
function admin_currency($amount) {
    return '$' . number_format((float)$amount, 2);
}

/**
 * Resolve asset image path relative to admin/ folder
 */
function admin_asset_img($path) {
    if (empty($path)) {
        return '../assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg';
    }
    if (strpos($path, 'http') === 0 || strpos($path, '../') === 0) {
        return $path;
    }
    return '../' . ltrim($path, '/');
}

require_once __DIR__ . '/../data/sample-data.php';

