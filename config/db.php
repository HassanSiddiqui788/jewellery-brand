<?php
/**
 * Database Configuration & Connection
 * MySQLi connection for Lorem Ipsum Store
 */

// Database Configuration Credentials
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'localhost');
if (!defined('DB_PASS')) define('DB_PASS', '@hassan123');
if (!defined('DB_NAME')) define('DB_NAME', 'jewels_db');
if (!defined('DB_PORT')) define('DB_PORT', 3306);

// Prevent uncaught mysqli exceptions in PHP 8.1+
mysqli_report(MYSQLI_REPORT_OFF);

// Global connection instance and error state
$conn = null;
$db_error = null;

try {
    // 1. Primary connection attempt using configured host
    $conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);

    // 2. Seamless fallback: if socket connection fails on Linux/Ubuntu, try 127.0.0.1 TCP
    if ($conn->connect_errno && DB_HOST === 'localhost') {
        $tcp_conn = @new mysqli('127.0.0.1', DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);
        if (!$tcp_conn->connect_errno) {
            $conn = $tcp_conn;
        }
    }

    // 3. Connection verification & error handling
    if ($conn->connect_errno) {
        $db_error = "Database Connection Failed [" . $conn->connect_errno . "]: " . $conn->connect_error;
        error_log($db_error);
        $conn = false;
    } else {
        // Set standard UTF-8 charset
        $conn->set_charset('utf8mb4');
    }
} catch (Exception $e) {
    $db_error = "Database Exception: " . $e->getMessage();
    error_log($db_error);
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

