<?php
$pageTitle = '404 Not Found';
ob_start();
?>
<div class="eyebrow">HTTP 404</div>
<h1>Page Not Found</h1>
<p><?= e($message ?? 'The requested resource could not be found.') ?></p>
<p><a class="btn" href="/index.php">Return to Storefront</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';

