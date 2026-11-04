<?php
/**
 * Blog Article Helper & Dispatcher
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$slug = $_GET['post'] ?? '';

if ($slug) {
    $target = __DIR__ . '/posts/' . basename($slug) . '/index.php';
    if (file_exists($target)) {
        include $target;
        exit;
    }
}

// Default redirect to blog index if no post specified or found
header('Location: ' . site_url('blog/index.php', $base_path));
exit;
