<?php
$pageTitle = '405 Method Not Allowed';
ob_start();
?>
<div class="eyebrow">HTTP 405</div>
<h1>Method Not Allowed</h1>
<p><?= e($message ?? 'The HTTP method used is not supported for this endpoint.') ?></p>
<?php if (!empty($allowedMethods)): ?>
    <p>Allowed methods: <code><?= e(implode(', ', $allowedMethods)) ?></code></p>
<?php endif; ?>
<p><a class="btn" href="/index.php">Return to Storefront</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';

