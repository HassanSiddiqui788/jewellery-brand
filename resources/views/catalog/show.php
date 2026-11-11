<?php
$pageTitle = $title ?? 'Product Detail';
ob_start();
?>
<div class="eyebrow"><?= e((string) ($product->categoryName ?? 'Jewelry')) ?></div>
<h1><?= e($product->name) ?></h1>
<p><?= e((string) ($product->description ?? '')) ?></p>

<table>
    <tr><th>Price</th><td><?= e(\Core\Helpers\Security::formatCurrency($product->effectivePrice())) ?></td></tr>
    <tr><th>Stock</th><td><?= e((string) $product->stockQuantity) ?></td></tr>
</table>

<p><a class="btn" href="/catalog">Back to Catalog</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';

