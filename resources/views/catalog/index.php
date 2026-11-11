<?php
$pageTitle = $title ?? 'Catalog';
ob_start();
?>
<div class="eyebrow">Curated Catalog</div>
<h1><?= e((string) ($title ?? 'Catalog')) ?></h1>

<?php if (!empty($products)): ?>
    <table>
        <thead><tr><th>Piece</th><th>Category</th><th>Price</th></tr></thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><a href="/catalog/product/<?= esc_attr($product->slug) ?>"><?= e($product->name) ?></a></td>
                <td><?= e((string) ($product->categoryName ?? 'Jewelry')) ?></td>
                <td><?= e(\Core\Helpers\Security::formatCurrency($product->effectivePrice())) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No active jewelry pieces matched your criteria.</p>
<?php endif; ?>

<p><a class="btn" href="/index.php">Return to Storefront</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';

