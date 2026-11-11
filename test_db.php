<?php
/**
 * Database Connection Verification Script
 * Accessible via CLI: `php test_db.php`
 * Or via Browser: `http://localhost:8000/test_db.php`
 */

require_once __DIR__ . '/config/db.php';

$is_cli = (php_sapi_name() === 'cli');

if (!$is_cli) {
    header('Content-Type: text/html; charset=utf-8');
}

$connected = is_db_connected();
$db = get_db_connection();
$error = get_db_error();

if ($is_cli) {
    echo "====================================================\n";
    echo "      MySQL Database Connection Diagnostics        \n";
    echo "====================================================\n";
    echo "Host:     " . DB_HOST . " (Port: " . DB_PORT . ")\n";
    echo "User:     " . DB_USER . "\n";
    echo "Database: " . DB_NAME . "\n";
    echo "----------------------------------------------------\n";

    if ($connected && $db) {
        echo "Status:   CONNECTED SUCCESSFULLY! (✓)\n";
        echo "Server:   MySQL " . $db->server_info . "\n";
        echo "Charset:  " . $db->character_set_name() . "\n";

        // Query existing tables in jewels_db (read-only inspection)
        $result = $db->query("SHOW TABLES");
        if ($result) {
            $table_count = $result->num_rows;
            echo "Tables:   " . $table_count . " table(s) found in `" . DB_NAME . "`\n";
            while ($row = $result->fetch_array()) {
                echo "          - " . $row[0] . "\n";
            }
            $result->free();
        }
        echo "====================================================\n";
        exit(0);
    } else {
        echo "Status:   CONNECTION FAILED (✗)\n";
        echo "Error:    " . ($error ?: 'Unknown error') . "\n";
        echo "----------------------------------------------------\n";
        echo "Troubleshooting:\n";
        echo "1. Ensure DB_USER and DB_PASS in config/db.php match the MySQL\n";
        echo "   username and password you use in phpMyAdmin.\n";
        echo "2. Or run inside MySQL (via phpMyAdmin SQL tab or sudo mysql):\n";
        $pw_hint = (DB_PASS === '') ? "''" : "'<your DB_PASS from config/db.php>'";
        echo "   ALTER USER 'root'@'localhost' IDENTIFIED BY " . $pw_hint . ";\n";
        echo "   CREATE USER IF NOT EXISTS 'root'@'127.0.0.1' IDENTIFIED BY " . $pw_hint . ";\n";
        echo "   GRANT ALL PRIVILEGES ON " . DB_NAME . ".* TO 'root'@'localhost';\n";
        echo "   GRANT ALL PRIVILEGES ON " . DB_NAME . ".* TO 'root'@'127.0.0.1';\n";
        echo "   FLUSH PRIVILEGES;\n";
        echo "====================================================\n";
        exit(1);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test – <?= htmlspecialchars(DB_NAME) ?></title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #F6F4F2;
            color: #051F34;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .card {
            background: #FFFFFF;
            max-width: 600px;
            width: 100%;
            border-radius: 12px;
            padding: 36px 32px;
            box-shadow: 0 10px 30px rgba(5, 31, 52, 0.08);
            border-top: 5px solid <?= $connected ? '#2e7d32' : '#c62828' ?>;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: <?= $connected ? '#e8f5e9' : '#ffebee' ?>;
            color: <?= $connected ? '#2e7d32' : '#c62828' ?>;
            margin-bottom: 16px;
        }
        h1 {
            font-size: 24px;
            margin: 0 0 10px;
            color: #051F34;
        }
        p {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ECEAE7;
        }
        td.label {
            font-weight: 600;
            color: #051F34;
            width: 140px;
        }
        .code-box {
            background: #051F34;
            color: #E2E8F0;
            padding: 16px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 13px;
            line-height: 1.5;
            overflow-x: auto;
            margin-top: 15px;
        }
        .btn {
            display: inline-block;
            margin-top: 24px;
            padding: 10px 24px;
            background: #051F34;
            color: #FFFFFF;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 1px;
        }
        .btn:hover {
            background: #CB9274;
        }
    </style>
</head>
<body>
    <div class="card">
        <span class="status-badge"><?= $connected ? 'Connected' : 'Connection Failed' ?></span>
        <h1>MySQL Database Status</h1>
        <p><?= $connected ? 'Your PHP project is successfully connected to the MySQL database.' : 'Could not establish connection with the configured credentials.' ?></p>

        <table>
            <tr>
                <td class="label">Host</td>
                <td><?= htmlspecialchars(DB_HOST) ?>:<?= htmlspecialchars(DB_PORT) ?></td>
            </tr>
            <tr>
                <td class="label">Username</td>
                <td><?= htmlspecialchars(DB_USER) ?></td>
            </tr>
            <tr>
                <td class="label">Database</td>
                <td><strong><?= htmlspecialchars(DB_NAME) ?></strong></td>
            </tr>
            <?php if ($connected && $db): ?>
            <tr>
                <td class="label">Server Version</td>
                <td>MySQL <?= htmlspecialchars($db->server_info) ?></td>
            </tr>
            <tr>
                <td class="label">Charset</td>
                <td><?= htmlspecialchars($db->character_set_name()) ?></td>
            </tr>
            <?php
            $res = $db->query("SHOW TABLES");
            $tbl_count = $res ? $res->num_rows : 0;
            ?>
            <tr>
                <td class="label">Existing Tables</td>
                <td><?= $tbl_count ?> table(s) found in database</td>
            </tr>
            <?php else: ?>
            <tr>
                <td class="label">Error Details</td>
                <td style="color: #c62828;"><?= htmlspecialchars($error ?: 'Unknown error') ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <?php if (!$connected): ?>
        <div style="margin-top: 24px;">
            <strong style="font-size: 13px; color: #051F34;">Why this error occurs &amp; how to fix it:</strong>
            <p style="font-size: 13px; margin-top: 6px;">Error <code>[1045]</code> means MySQL is running, but rejected <code><?= htmlspecialchars(DB_USER) ?></code> with the password currently set in <code>config/db.php</code> (password <?= DB_PASS === '' ? 'empty' : 'provided' ?>).</p>
            <p style="font-size: 13px; margin-top: 6px;"><strong>1.</strong> Update <code>DB_USER</code> / <code>DB_PASS</code> in <code>config/db.php</code> to match the exact username &amp; password you use in phpMyAdmin.<br><strong>2.</strong> Or run this SQL in phpMyAdmin (SQL tab) / terminal (<code>sudo mysql</code>) so MySQL accepts your configured password:</p>
            <?php $sql_pw_hint = (DB_PASS === '') ? "''" : "'&lt;your_DB_PASS&gt;'"; ?>
            <div class="code-box">ALTER USER 'root'@'localhost' IDENTIFIED BY <?= $sql_pw_hint ?>; CREATE USER IF NOT EXISTS 'root'@'127.0.0.1' IDENTIFIED BY <?= $sql_pw_hint ?>; GRANT ALL PRIVILEGES ON <?= htmlspecialchars(DB_NAME) ?>.* TO 'root'@'localhost'; GRANT ALL PRIVILEGES ON <?= htmlspecialchars(DB_NAME) ?>.* TO 'root'@'127.0.0.1'; FLUSH PRIVILEGES;</div>
        </div>
        <?php endif; ?>

        <a href="index.php" class="btn">&larr; Return to Website</a>
    </div>
</body>
</html>

