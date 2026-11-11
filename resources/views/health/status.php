<?php
$pageTitle = 'System Health';
$snapshot = $snapshot ?? [];
$appInfo = $snapshot['application'] ?? [];
$dbInfo = $snapshot['database'] ?? [];
ob_start();
?>
<div class="eyebrow">Architecture Readiness</div>
<h1>System &amp; Database Status</h1>
<p>Overall Status: <strong><?= e(strtoupper((string) ($snapshot['status'] ?? 'unknown'))) ?></strong></p>

<table>
    <tr><th>Application</th><td><?= e((string) ($appInfo['name'] ?? '')) ?> (<?= e((string) ($appInfo['env'] ?? '')) ?>)</td></tr>
    <tr><th>PHP Version</th><td><?= e((string) ($appInfo['php_version'] ?? PHP_VERSION)) ?></td></tr>
    <tr><th>Currency</th><td><?= e((string) ($appInfo['currency'] ?? 'PKR')) ?></td></tr>
    <tr><th>Database Driver</th><td><?= e((string) ($dbInfo['driver'] ?? 'mysql')) ?> (<?= e((string) ($dbInfo['database'] ?? '')) ?>)</td></tr>
    <tr><th>PDO Connection</th><td><?= !empty($dbInfo['connected']) ? 'Connected' : 'Disconnected' ?></td></tr>
    <tr><th>Existing Tables</th><td><?= $dbInfo['tables_count'] !== null ? e((string) $dbInfo['tables_count']) : 'Unavailable' ?></td></tr>
</table>

<p><a class="btn" href="/index.php">Return to Storefront</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';

