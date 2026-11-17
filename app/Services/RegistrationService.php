<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Service: User Registration Handler
 * Handles dynamic user registration with server-side validation, duplicate email checking,
 * password hashing (PASSWORD_DEFAULT), and insertion into the MySQL `users` table.
 */
final class RegistrationService
{
    /**
     * SQL schema for creating the `users` table automatically if it does not exist.
     */
    public const CREATE_TABLE_SQL = <<<'SQL'
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

    /**
     * Resolves a working database connection (PDO preferred, MySQLi fallback).
     *
     * @return \PDO|\mysqli
     */
    public static function getConnection(): \PDO|\mysqli
    {
        // 1. Try existing PDO connection wrapper if available
        if (function_exists('get_pdo_connection')) {
            try {
                $conn = get_pdo_connection();
                $pdo = $conn->pdo();
                if ($pdo instanceof \PDO) {
                    return $pdo;
                }
            } catch (\Throwable) {
                // Fall through to standalone connection
            }
        }

        // 2. Ensure db.php is loaded for constants
        if (!defined('DB_HOST')) {
            $dbConfigPath = dirname(__DIR__, 2) . '/config/db.php';
            if (is_file($dbConfigPath)) {
                require_once $dbConfigPath;
            }
        }

        $host = defined('DB_HOST') ? (string) DB_HOST : 'localhost';
        $user = defined('DB_USER') ? (string) DB_USER : 'root';
        $pass = defined('DB_PASS') ? (string) DB_PASS : '';
        $dbname = defined('DB_NAME') ? (string) DB_NAME : 'jewels_db';
        $port = defined('DB_PORT') ? (int) DB_PORT : 3306;

        // Try direct PDO connection
        try {
            if (file_exists('/tmp/mysql.sock')) {
                $dsn = sprintf('mysql:unix_socket=/tmp/mysql.sock;dbname=%s;charset=utf8mb4', $dbname);
            } else {
                $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $host, $port, $dbname);
            }
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];
            return new \PDO($dsn, $user, $pass, $options);
        } catch (\Throwable) {
            // 3. Fallback to MySQLi
            if (function_exists('get_db_connection')) {
                $mysqli = get_db_connection();
                if ($mysqli instanceof \mysqli) {
                    return $mysqli;
                }
            }
            throw new \RuntimeException('Unable to establish database connection for user registration.');
        }
    }

    /**
     * Creates the `users` table automatically if it does not exist.
     *
     * @param \PDO|\mysqli|null $connection
     */
    public static function ensureUsersTable(\PDO|\mysqli|null $connection = null): void
    {
        $conn = $connection ?? self::getConnection();

        if ($conn instanceof \PDO) {
            $conn->exec(self::CREATE_TABLE_SQL);
        } elseif ($conn instanceof \mysqli) {
            if (!$conn->query(self::CREATE_TABLE_SQL)) {
                throw new \RuntimeException('Failed to create users table: ' . $conn->error);
            }
        }
    }

    /**
     * Validates registration input fields.
     *
     * @param array<string, mixed> $data
     * @param \PDO|\mysqli|null $connection
     * @return array{valid: bool, errors: array<string, string>, clean: array<string, string>}
     */
    public static function validate(array $data, \PDO|\mysqli|null $connection = null): array
    {
        $errors = [];

        // 1. Full Name
        $fullName = isset($data['full_name']) ? trim((string) $data['full_name']) : '';
        if ($fullName === '') {
            $errors['full_name'] = 'Full Name is required.';
        } elseif (mb_strlen($fullName, 'UTF-8') < 2) {
            $errors['full_name'] = 'Full Name must be at least 2 characters.';
        } elseif (mb_strlen($fullName, 'UTF-8') > 150) {
            $errors['full_name'] = 'Full Name cannot exceed 150 characters.';
        } elseif (!preg_match("/^[\p{L}\s\-\.'’]+$/u", $fullName)) {
            $errors['full_name'] = 'Full Name contains invalid characters.';
        }

        // 2. Email Address
        $email = isset($data['email']) ? trim((string) $data['email']) : '';
        if ($email === '') {
            $errors['email'] = 'Email Address is required.';
        } elseif (strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        // 3. Password
        $password = isset($data['password']) ? (string) $data['password'] : '';
        if ($password === '') {
            $errors['password'] = 'Password is required.';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must contain at least 8 characters.';
        }

        // 4. Confirm Password
        $confirmPassword = isset($data['confirm_password']) ? (string) $data['confirm_password'] : '';
        if ($confirmPassword === '') {
            $errors['confirm_password'] = 'Please confirm your password.';
        } elseif ($password !== '' && $password !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match.';
        }

        // 5. Check duplicate email in `users` table if email format is valid
        if (!isset($errors['email'])) {
            $normalizedEmail = strtolower($email);
            if (self::emailExists($normalizedEmail, $connection)) {
                $errors['email'] = 'This email address is already registered.';
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'clean' => [
                'full_name' => $fullName,
                'email' => strtolower($email),
                'password' => $password,
            ],
        ];
    }

    /**
     * Checks if an email address already exists in the `users` table using prepared statements.
     *
     * @param string $email
     * @param \PDO|\mysqli|null $connection
     * @return bool
     */
    public static function emailExists(string $email, \PDO|\mysqli|null $connection = null): bool
    {
        $conn = $connection ?? self::getConnection();
        $normalized = strtolower(trim($email));

        if ($conn instanceof \PDO) {
            $stmt = $conn->prepare('SELECT id FROM users WHERE LOWER(email) = LOWER(:email) LIMIT 1');
            $stmt->execute([':email' => $normalized]);
            return $stmt->fetchColumn() !== false;
        }

        if ($conn instanceof \mysqli) {
            $stmt = $conn->prepare('SELECT id FROM users WHERE LOWER(email) = LOWER(?) LIMIT 1');
            if ($stmt === false) {
                return false;
            }
            $stmt->bind_param('s', $normalized);
            $stmt->execute();
            $stmt->store_result();
            $exists = $stmt->num_rows > 0;
            $stmt->close();
            return $exists;
        }

        return false;
    }

    /**
     * Processes registration: validates input, hashes password, and inserts into `users` table.
     *
     * @param array<string, mixed> $data
     * @param \PDO|\mysqli|null $connection
     * @return array{success: bool, message: string, errors?: array<string, string>, user?: array{id: int, full_name: string, email: string}}
     */
    public static function register(array $data, \PDO|\mysqli|null $connection = null): array
    {
        try {
            $conn = $connection ?? self::getConnection();

            // Ensure table exists
            self::ensureUsersTable($conn);

            // Validate all inputs
            $validation = self::validate($data, $conn);
            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'message' => 'Please correct the errors below.',
                    'errors' => $validation['errors'],
                ];
            }

            $clean = $validation['clean'];

            // Hash password securely using PASSWORD_DEFAULT
            $hashedPassword = password_hash($clean['password'], PASSWORD_DEFAULT);

            // Insert into `users` table using prepared statements
            if ($conn instanceof \PDO) {
                $sql = 'INSERT INTO users (full_name, email, password) VALUES (:full_name, :email, :password)';
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':full_name' => $clean['full_name'],
                    ':email' => $clean['email'],
                    ':password' => $hashedPassword,
                ]);
                $newId = (int) $conn->lastInsertId();
            } else {
                $sql = 'INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)';
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    throw new \RuntimeException('Failed to prepare user insertion statement: ' . $conn->error);
                }
                $stmt->bind_param('sss', $clean['full_name'], $clean['email'], $hashedPassword);
                if (!$stmt->execute()) {
                    throw new \RuntimeException('Failed to insert user: ' . $stmt->error);
                }
                $newId = (int) $conn->insert_id;
                $stmt->close();
            }

            return [
                'success' => true,
                'message' => 'Account registered successfully! Welcome to Lorem Ipsum.',
                'user' => [
                    'id' => $newId,
                    'full_name' => $clean['full_name'],
                    'email' => $clean['email'],
                ],
            ];
        } catch (\PDOException $e) {
            // Handle duplicate email race condition (MySQL error 1062 / SQLSTATE 23000)
            if ($e->getCode() === '23000' || (isset($e->errorInfo[1]) && (int) $e->errorInfo[1] === 1062)) {
                return [
                    'success' => false,
                    'message' => 'Registration failed.',
                    'errors' => [
                        'email' => 'This email address is already registered.',
                    ],
                ];
            }
            return [
                'success' => false,
                'message' => 'A database error occurred during registration. Please try again later.',
                'errors' => [
                    'general' => 'Database error: ' . $e->getMessage(),
                ],
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'An error occurred during registration. Please try again.',
                'errors' => [
                    'general' => $e->getMessage(),
                ],
            ];
        }
    }
}
