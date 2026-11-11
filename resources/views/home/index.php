<?php
$pageTitle = $title ?? 'Home';
ob_start();
?>
<div class="eyebrow">Luxury Jewellery House</div>
<h1><?= e((string) ($title ?? 'Lorem Ipsum')) ?></h1>
<p><?= e((string) ($tagline ?? '')) ?></p>

<?php if (!empty($categories)): ?>
    <table>
        <thead><tr><th>Collection</th><th>Slug</th></tr></thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><a href="/catalog/category/<?= esc_attr($category->slug) ?>"><?= e($category->name) ?></a></td>
                <td><code><?= e($category->slug) ?></code></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No active categories loaded yet. Visit the storefront or check <code>/health</code>.</p>
<?php endif; ?>

<p>
    <a class="btn" href="/catalog">Browse Catalog</a>
    <a class="btn" href="/health" style="background:#CB9274;">System Health</a>
</p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';

