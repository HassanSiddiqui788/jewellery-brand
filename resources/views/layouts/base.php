<?php
/** @var string $pageTitle */
$pageTitle = $pageTitle ?? (string) config('app.name', 'JARWAYA JEWELS');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> — <?= e((string) config('app.name', 'JARWAYA JEWELS')) ?></title>
    <style>
        :root {
            --bg-cream: #F9F8F6;
            --surface: #FFFFFF;
            --navy: #051F34;
            --gold: #CB9274;
            --border: #ECEAE7;
            --muted: #6C757D;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-cream);
            color: var(--navy);
            line-height: 1.6;
        }
        .shell {
            max-width: 960px;
            margin: 48px auto;
            padding: 0 20px;
        }
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 36px;
            box-shadow: 0 12px 32px rgba(5, 31, 52, 0.06);
            border-top: 4px solid var(--gold);
        }
        .eyebrow {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 8px;
        }
        h1 {
            margin: 0 0 12px;
            font-size: 28px;
            font-weight: 600;
        }
        p { color: var(--muted); }
        .btn {
            display: inline-block;
            padding: 10px 22px;
            background: var(--navy);
            color: #FFFFFF;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            letter-spacing: 0.8px;
        }
        .btn:hover { background: var(--gold); }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }
        th { color: var(--navy); font-weight: 600; width: 220px; }
    </style>
</head>
<body>
<div class="shell">
    <div class="card">
        <?= $content ?? '' ?>
    </div>
</div>
</body>
</html>

