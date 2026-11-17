<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Service: User Authentication Handler
 * Handles secure session-based login, password verification via password_verify(),
 * session fixation prevention (session_regenerate_id), user state checks, and clean logout.
 */
final class AuthService
{
    public const SESSION_USER_ID = 'user_id';
    public const SESSION_USER_NAME = 'user_name';
    public const SESSION_USER_EMAIL = 'user_email';
    public const SESSION_IS_LOGGED_IN = 'is_logged_in';

    /**
     * Ensures PHP session is initialized securely.
     */
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            $currentPath = session_save_path();
            if (empty($currentPath) || !is_writable($currentPath)) {
                $tempPath = sys_get_temp_dir();
                if (is_writable($tempPath)) {
                    session_save_path($tempPath);
                }
            }

            // Apply secure session cookie settings if not yet set
            if (!ini_get('session.cookie_httponly')) {
                @ini_set('session.cookie_httponly', '1');
            }
            session_start();
        }
    }

    /**
     * Checks whether the user is currently authenticated.
     */
    public static function check(): bool
    {
        self::startSession();
        return !empty($_SESSION[self::SESSION_USER_ID]);
    }

    /**
     * Returns the currently authenticated user payload, or null if guest.
     *
     * @return array{id: int, full_name: string, email: string}|null
     */
    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }

        return [
            'id' => (int) $_SESSION[self::SESSION_USER_ID],
            'full_name' => (string) ($_SESSION[self::SESSION_USER_NAME] ?? ''),
            'email' => (string) ($_SESSION[self::SESSION_USER_EMAIL] ?? ''),
        ];
    }

    /**
     * Returns the authenticated user's ID, or null.
     */
    public static function id(): ?int
    {
        return self::check() ? (int) $_SESSION[self::SESSION_USER_ID] : null;
    }

    /**
     * Authenticates a user with email and password against the MySQL `users` table.
     *
     * @param string $email
     * @param string $password
     * @param \PDO|\mysqli|null $connection
     * @return array{success: bool, message: string, errors?: array<string, string>, redirect?: string, user?: array{id: int, full_name: string, email: string}}
     */
    public static function login(string $email, string $password, \PDO|\mysqli|null $connection = null): array
    {
        $errors = [];

        $cleanEmail = trim($email);
        $cleanPassword = (string) $password;

        // 1. Server-side Input Validation
        if ($cleanEmail === '') {
            $errors['email'] = 'Email Address is required.';
        } elseif (!filter_var($cleanEmail, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        if ($cleanPassword === '') {
            $errors['password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'Please fill in all required fields.',
                'errors' => $errors,
            ];
        }

        try {
            $conn = $connection ?? RegistrationService::getConnection();

            // Ensure table exists
            RegistrationService::ensureUsersTable($conn);

            $normalizedEmail = strtolower($cleanEmail);
            $userRecord = null;

            // 2. Query user by email using prepared statements
            if ($conn instanceof \PDO) {
                $stmt = $conn->prepare('SELECT id, full_name, email, password FROM users WHERE LOWER(email) = LOWER(:email) LIMIT 1');
                $stmt->execute([':email' => $normalizedEmail]);
                $userRecord = $stmt->fetch(\PDO::FETCH_ASSOC);
            } elseif ($conn instanceof \mysqli) {
                $stmt = $conn->prepare('SELECT id, full_name, email, password FROM users WHERE LOWER(email) = LOWER(?) LIMIT 1');
                if ($stmt === false) {
                    throw new \RuntimeException('Failed to prepare login statement: ' . $conn->error);
                }
                $stmt->bind_param('s', $normalizedEmail);
                $stmt->execute();
                $res = $stmt->get_result();
                $userRecord = $res ? $res->fetch_assoc() : null;
                $stmt->close();
            }

            // 3. Email existence check
            if (!$userRecord || empty($userRecord['id'])) {
                return [
                    'success' => false,
                    'message' => 'No account found with this email address.',
                    'errors' => [
                        'email' => 'No account found with this email address.',
                    ],
                ];
            }

            // 4. Password verification using password_verify()
            $storedHash = (string) ($userRecord['password'] ?? '');
            if (!password_verify($cleanPassword, $storedHash)) {
                return [
                    'success' => false,
                    'message' => 'Incorrect password. Please try again.',
                    'errors' => [
                        'password' => 'Incorrect password. Please try again.',
                    ],
                ];
            }

            // 5. Establish authenticated session & regenerate session ID to prevent fixation attacks
            self::startSession();
            if (!headers_sent()) {
                session_regenerate_id(true);
            }

            $_SESSION[self::SESSION_USER_ID] = (int) $userRecord['id'];
            $_SESSION[self::SESSION_USER_NAME] = (string) $userRecord['full_name'];
            $_SESSION[self::SESSION_USER_EMAIL] = (string) $userRecord['email'];
            $_SESSION[self::SESSION_IS_LOGGED_IN] = true;

            return [
                'success' => true,
                'message' => 'Welcome back, ' . $userRecord['full_name'] . '! Login successful.',
                'redirect' => '../index.php',
                'user' => [
                    'id' => (int) $userRecord['id'],
                    'full_name' => (string) $userRecord['full_name'],
                    'email' => (string) $userRecord['email'],
                ],
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'An unexpected error occurred during sign in. Please try again.',
                'errors' => [
                    'general' => 'Database error: ' . $e->getMessage(),
                ],
            ];
        }
    }

    /**
     * Terminates the user session completely and safely.
     */
    public static function logout(): void
    {
        self::startSession();

        // Clear session variables
        $_SESSION = [];

        // Expire session cookie
        if (ini_get('session.use_cookies') && !headers_sent()) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'] ?? '/',
                $params['domain'] ?? '',
                (bool) ($params['secure'] ?? false),
                (bool) ($params['httponly'] ?? true)
            );
        }

        // Destroy session data on server
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    /**
     * Protects pages from unauthorized guest access.
     */
    public static function requireAuth(string $redirectUrl = '../pages/login.php'): void
    {
        if (!self::check()) {
            if (!headers_sent()) {
                header('Location: ' . $redirectUrl);
            }
            exit;
        }
    }
}
