<?php
/**
 * Database Configuration & Connection (Backward-Compatible Bridge)
 * Reads credentials centrally from .env / config/database.php while preserving
 * legacy MySQLi helpers ($conn, get_db_connection, is_db_connected, get_db_error).
 */

require_once __DIR__ . '/../bootstrap/autoload.php';

if (!\Core\Config\EnvLoader::isLoaded() && is_file(BASE_PATH . '/.env')) {
    \Core\Config\EnvLoader::load(BASE_PATH . '/.env');
}

if (!defined('DB_HOST')) define('DB_HOST', (string) env('DB_HOST', 'localhost'));
if (!defined('DB_USER')) define('DB_USER', (string) env('DB_USERNAME', 'root'));
if (!defined('DB_PASS')) define('DB_PASS', (string) env('DB_PASSWORD', ''));
if (!defined('DB_NAME')) define('DB_NAME', (string) env('DB_DATABASE', 'jewels_db'));
if (!defined('DB_PORT')) define('DB_PORT', (int) env('DB_PORT', 3306));

$conn = false;
$db_error = null;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $socket = env('DB_SOCKET') ?: (file_exists('/tmp/mysql.sock') ? '/tmp/mysql.sock' : null);
    try {
        if ($socket) {
            $conn = @new mysqli(null, DB_USER, DB_PASS, DB_NAME, null, $socket);
        } else {
            $conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        }
    } catch (Throwable $socketException) {
        if (DB_HOST === 'localhost' && !$socket) {
            $conn = @new mysqli('127.0.0.1', DB_USER, DB_PASS, DB_NAME, DB_PORT);
        } elseif (file_exists('/tmp/mysql.sock')) {
            $conn = @new mysqli(null, DB_USER, DB_PASS, DB_NAME, null, '/tmp/mysql.sock');
        } else {
            throw $socketException;
        }
    }

    if ($conn instanceof mysqli) {
        $charset = (string) env('DB_CHARSET', 'utf8mb4');
        $conn->set_charset($charset !== '' ? $charset : 'utf8mb4');
    }
} catch (Throwable $e) {
    $db_error = 'Database Connection Failed [' . (int) $e->getCode() . ']: ' . $e->getMessage();
    if (function_exists('app_logger')) {
        app_logger()->warning('Legacy MySQLi connection unavailable', [
            'code' => (int) $e->getCode(),
            'host' => DB_HOST,
            'database' => DB_NAME,
        ]);
    }
    $conn = false;
}

/**
 * Returns the active MySQLi connection instance, or false if unavailable
 *
 * @return mysqli|false
 */
function get_db_connection() {
    global $conn;
    return $conn;
}

/**
 * Checks whether the database connection is currently active and reachable
 *
 * @return bool
 */
function is_db_connected() {
    global $conn;
    return ($conn instanceof mysqli) && @$conn->ping();
}

/**
 * Returns the last database connection error message if any
 *
 * @return string|null
 */
function get_db_error() {
    global $db_error, $conn;
    if ($db_error) {
        return $db_error;
    }
    if ($conn instanceof mysqli && $conn->connect_error) {
        return $conn->connect_error;
    }
    return null;
}

/**
 * Returns the shared Core PDO Connection wrapper managed by bootstrap/app.php.
 */
function get_pdo_connection(): \Core\Database\Connection {
    require_once BASE_PATH . '/bootstrap/app.php';
    return app_bootstrap(PHP_SAPI !== 'cli')->db();
}
