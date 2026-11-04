<?php
/**
 * Breadcrumb Component
 * Bijoux Jewelry Store
 *
 * @param array $breadcrumbs List of ['title' => '...', 'url' => '...']
 */
if (!defined('BIJOUX_APP')) {
    require_once __DIR__ . '/../config.php';
}
$base_path = $base_path ?? './';
$items = $breadcrumbs ?? [
    ['title' => 'Home', 'url' => site_url('index.php', $base_path)]
];
?>
<nav class="woocommerce-breadcrumb" aria-label="Breadcrumb">
    <?php foreach ($items as $idx => $crumb): ?>
        <?php if ($idx > 0): ?>
            <span class="delimiter">&#47;</span>
        <?php endif; ?>
        <?php if (!empty($crumb['url']) && $idx < count($items) - 1): ?>
            <a href="<?= htmlspecialchars($crumb['url']) ?>"><?= htmlspecialchars($crumb['title']) ?></a>
        <?php else: ?>
            <span class="current"><?= htmlspecialchars($crumb['title']) ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>

