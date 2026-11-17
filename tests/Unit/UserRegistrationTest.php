<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\RegistrationService;
use Tests\Assert;

final class UserRegistrationTest
{
    private function getPdo(): \PDO
    {
        $conn = RegistrationService::getConnection();
        if ($conn instanceof \PDO) {
            return $conn;
        }
        Assert::skip('PDO connection required for registration unit test assertions.');
    }

    public function testUsersTableAutoCreation(): void
    {
        $pdo = $this->getPdo();

        // Ensure users table is created
        RegistrationService::ensureUsersTable($pdo);

        // Verify table exists in jewels_db
        $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
        $tables = $stmt->fetchAll();
        Assert::true(count($tables) > 0, "Table 'users' should exist in the database.");

        // Verify column structure
        $colsStmt = $pdo->query("SHOW COLUMNS FROM users");
        $cols = $colsStmt->fetchAll(\PDO::FETCH_COLUMN, 0);

        Assert::true(in_array('id', $cols, true), "Column 'id' missing in users table.");
        Assert::true(in_array('full_name', $cols, true), "Column 'full_name' missing in users table.");
        Assert::true(in_array('email', $cols, true), "Column 'email' missing in users table.");
        Assert::true(in_array('password', $cols, true), "Column 'password' missing in users table.");
        Assert::true(in_array('created_at', $cols, true), "Column 'created_at' missing in users table.");
    }

    public function testEmptyFieldsValidation(): void
    {
        $pdo = $this->getPdo();
        $res = RegistrationService::register([
            'full_name' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
        ], $pdo);

        Assert::false($res['success'], 'Registration with empty fields should fail.');
        Assert::true(isset($res['errors']['full_name']), 'Full Name empty error expected.');
        Assert::true(isset($res['errors']['email']), 'Email Address empty error expected.');
        Assert::true(isset($res['errors']['password']), 'Password empty error expected.');
        Assert::true(isset($res['errors']['confirm_password']), 'Confirm Password empty error expected.');
    }

    public function testInvalidEmailValidation(): void
    {
        $pdo = $this->getPdo();
        $invalidEmails = ['notanemail', 'test@', '@domain.com', 'user@domain..com'];

        foreach ($invalidEmails as $badEmail) {
            $res = RegistrationService::register([
                'full_name' => 'John Doe',
                'email' => $badEmail,
                'password' => 'ValidPass123',
                'confirm_password' => 'ValidPass123',
            ], $pdo);

            Assert::false($res['success'], "Email '{$badEmail}' should be rejected.");
            Assert::same('Please enter a valid email address.', $res['errors']['email'] ?? '');
        }
    }

    public function testPasswordShorterThan8Characters(): void
    {
        $pdo = $this->getPdo();
        $res = RegistrationService::register([
            'full_name' => 'Eleanor Vance',
            'email' => 'eleanor.short@example.com',
            'password' => '1234567',
            'confirm_password' => '1234567',
        ], $pdo);

        Assert::false($res['success'], 'Password shorter than 8 chars should fail.');
        Assert::same('Password must contain at least 8 characters.', $res['errors']['password'] ?? '');
    }

    public function testPasswordMismatch(): void
    {
        $pdo = $this->getPdo();
        $res = RegistrationService::register([
            'full_name' => 'Eleanor Vance',
            'email' => 'eleanor.mismatch@example.com',
            'password' => 'SecretPass123',
            'confirm_password' => 'DifferentPass456',
        ], $pdo);

        Assert::false($res['success'], 'Mismatched passwords should fail.');
        Assert::same('Passwords do not match.', $res['errors']['confirm_password'] ?? '');
    }

    public function testSuccessfulRegistrationAndDbInsertion(): void
    {
        $pdo = $this->getPdo();
        $uniqueEmail = 'user_' . bin2hex(random_bytes(4)) . '@example.com';
        $plainPassword = 'LuxurySecretPassword2026!';

        $res = RegistrationService::register([
            'full_name' => 'Eleanor Vance',
            'email' => $uniqueEmail,
            'password' => $plainPassword,
            'confirm_password' => $plainPassword,
        ], $pdo);

        Assert::true($res['success'], 'Valid registration should succeed.');
        Assert::true(isset($res['user']['id']) && $res['user']['id'] > 0, 'New user ID should be returned.');

        $userId = $res['user']['id'];

        // Directly query MySQL to verify the user was actually inserted
        $stmt = $pdo->prepare('SELECT id, full_name, email, password, created_at FROM users WHERE id = :id');
        $stmt->execute([':id' => $userId]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        Assert::true($row !== false, 'Inserted user must be found in MySQL users table.');
        Assert::same('Eleanor Vance', $row['full_name']);
        Assert::same(strtolower($uniqueEmail), $row['email']);

        // Verify password is NOT saved in plain text
        Assert::notContains($plainPassword, $row['password'], 'Plain-text password must never be saved in database.');

        // Verify password was securely hashed with password_hash() / PASSWORD_DEFAULT
        Assert::true(password_verify($plainPassword, $row['password']), 'password_verify() must match hashed password.');
    }

    public function testDuplicateEmailPrevention(): void
    {
        $pdo = $this->getPdo();
        $dupEmail = 'duplicate_' . bin2hex(random_bytes(4)) . '@example.com';
        $pass = 'ValidPassword2026';

        // First registration
        $first = RegistrationService::register([
            'full_name' => 'First User',
            'email' => $dupEmail,
            'password' => $pass,
            'confirm_password' => $pass,
        ], $pdo);
        Assert::true($first['success'], 'First registration should succeed.');

        // Second registration with same email (even with different case)
        $second = RegistrationService::register([
            'full_name' => 'Second User',
            'email' => strtoupper($dupEmail),
            'password' => $pass,
            'confirm_password' => $pass,
        ], $pdo);

        Assert::false($second['success'], 'Duplicate email registration must fail.');
        Assert::same('This email address is already registered.', $second['errors']['email'] ?? '');

        // Verify only 1 record exists in MySQL
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE LOWER(email) = LOWER(:email)');
        $stmt->execute([':email' => $dupEmail]);
        $count = (int) $stmt->fetchColumn();
        Assert::same(1, $count, 'There must only be 1 user with this email in MySQL.');
    }

    public function testAjaxEndpointDirectPostHandling(): void
    {
        $script = sprintf(
            '$_SERVER["REQUEST_METHOD"] = "POST"; ' .
            '$_SERVER["HTTP_X_REQUESTED_WITH"] = "xmlhttprequest"; ' .
            '$_POST = ["full_name" => "Ajax User", "email" => "%s", "password" => "AjaxPass1234", "confirm_password" => "AjaxPass1234", "ajax" => "1"]; ' .
            'ob_start(); ' .
            'require %s; ' .
            '$out = ob_get_clean(); ' .
            'echo $out;',
            'ajax_' . bin2hex(random_bytes(4)) . '@example.com',
            var_export(BASE_PATH . '/pages/register.php', true)
        );

        $output = [];
        $code = 0;
        exec(PHP_BINARY . ' -r ' . escapeshellarg($script), $output, $code);

        Assert::same(0, $code, 'pages/register.php AJAX POST execution failed.');
        $jsonStr = implode('', $output);
        $decoded = json_decode($jsonStr, true);

        Assert::true(is_array($decoded), 'Response from pages/register.php must be valid JSON: ' . $jsonStr);
        Assert::true(isset($decoded['success']) && $decoded['success'] === true, 'JSON response should have success: true.');
        Assert::true(isset($decoded['user']['id']), 'JSON response should return registered user ID.');
    }
}
