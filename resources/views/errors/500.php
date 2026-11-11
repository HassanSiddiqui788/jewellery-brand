<?php
$status = (int) ($statusCode ?? 500);
$pageTitle = 'Error ' . $status;
ob_start();
?>
<div class="eyebrow">HTTP <?= e((string) $status) ?></div>
<h1><?= $status === 419 ? 'Security Token Expired' : 'Unexpected Application Error' ?></h1>
<p><?= e($message ?? 'An unexpected error occurred.') ?></p>
<?php if (!empty($debugDetail)): ?>
    <pre style="background:#051F34;color:#ECEAE7;padding:14px;border-radius:8px;overflow:auto;font-size:12px;"><?= e((string) $debugDetail) ?></pre>
<?php endif; ?>
<p><a class="btn" href="/index.php">Return to Storefront</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';

