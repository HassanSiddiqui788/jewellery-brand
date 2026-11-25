<?php
declare(strict_types=1);

/**
 * JARWAYA JEWELS - Live Search API Endpoint
 * Returns matching products in real-time as JSON
 */
require_once __DIR__ . '/../includes/config.php';

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-cache, must-revalidate');

$query = isset($_GET['q']) ? trim((string)$_GET['q']) : '';

if ($query === '' || mb_strlen($query) < 1) {
    echo json_encode([
        'success' => true,
        'count' => 0,
        'query' => $query,
        'results' => []
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

$base_path = isset($_GET['base']) && is_string($_GET['base']) ? trim($_GET['base']) : './';
if ($base_path !== './' && $base_path !== '../' && $base_path !== '../../') {
    $base_path = './';
}

$products = get_catalog_products(null, 10, $query);

$results = [];
foreach ($products as $p) {
    $results[] = [
        'id' => $p->id,
        'name' => $p->name,
        'slug' => $p->slug,
        'category' => $p->categoryName ?? 'Fine Jewellery',
        'price' => format_price($p->effectivePrice()),
        'image' => $base_path . ($p->mainImage ?? ''),
        'url' => $base_path . 'shop/product/' . $p->slug . '/index.php'
    ];
}

echo json_encode([
    'success' => true,
    'count' => count($results),
    'query' => $query,
    'results' => $results
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
