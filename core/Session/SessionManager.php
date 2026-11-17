<?php

declare(strict_types=1);

namespace Core\Session;

/**
 * Hardened session & CSRF token manager.
 * Infrastructure only: does not handle authentication, login, or role authorization in Phase 1.
 */
final class SessionManager
{
    private const CSRF_KEY = '_csrf_token';
    private const FLASH_NEW_KEY = '_flash_new';
    private const FLASH_OLD_KEY = '_flash_old';
    private const LAST_ACTIVITY_KEY = '_last_activity';

    private bool $started = false;

    /** @var array<string, mixed> */
    private array $config;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Resolve cookie configuration array enforcing HttpOnly, SameSite, and HTTPS awareness.
     *
     * @return array{lifetime:int,path:string,domain:string,secure:bool,httponly:bool,samesite:string}
     */
    public function getCookieOptions(?bool $isHttps = null): array
    {
        $lifetimeSeconds = max(60, ((int) ($this->config['lifetime'] ?? 120)) * 60);
        $secureSetting = $this->config['secure'] ?? 'auto';

        if ($secureSetting === 'auto') {
            $httpsFlag = $isHttps ?? (
                (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
                || strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https'
            );
            $secure = (bool) $httpsFlag;
        } else {
            $secure = filter_var($secureSetting, FILTER_VALIDATE_BOOLEAN);
        }

        $sameSite = (string) ($this->config['same_site'] ?? 'Lax');
        if (!in_array($sameSite, ['Lax', 'Strict', 'None'], true)) {
            $sameSite = 'Lax';
        }

        if ($sameSite === 'None' && !$secure) {
            // Browsers reject SameSite=None over plain HTTP; keep Lax over non-HTTPS
            $sameSite = 'Lax';
        }

        return [
            'lifetime' => $lifetimeSeconds,
            'path' => (string) ($this->config['path'] ?? '/'),
            'domain' => (string) ($this->config['domain'] ?? ''),
            'secure' => $secure,
            'httponly' => filter_var($this->config['http_only'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'samesite' => $sameSite,
        ];
    }

    public function start(): bool
    {
        if ($this->started) {
            return true;
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            $this->started = true;
            $this->cycleFlashData();
            return true;
        }

        // In CLI unit tests or after headers already sent, manage $_SESSION cleanly in memory
        if (PHP_SAPI === 'cli' || headers_sent()) {
            if (!isset($_SESSION) || !is_array($_SESSION)) {
                $_SESSION = [];
            }
            $this->started = true;
            $this->cycleFlashData();
            return true;
        }

        $cookieOptions = $this->getCookieOptions();

        $currentPath = session_save_path();
        if (empty($currentPath) || !is_writable($currentPath)) {
            $tempPath = sys_get_temp_dir();
            if (is_writable($tempPath)) {
                session_save_path($tempPath);
            }
        }

        @ini_set('session.use_only_cookies', '1');
        @ini_set('session.use_strict_mode', ($this->config['use_strict_mode'] ?? true) ? '1' : '0');
        @ini_set('session.cookie_httponly', $cookieOptions['httponly'] ? '1' : '0');
        @ini_set('session.gc_maxlifetime', (string) $cookieOptions['lifetime']);

        $sessionName = (string) ($this->config['name'] ?? 'bijoux_session');
        if ($sessionName !== '') {
            session_name($sessionName);
        }

        session_set_cookie_params($cookieOptions);

        if (session_start()) {
            $this->started = true;
            $this->enforceIdleLifetime($cookieOptions['lifetime']);
            $this->cycleFlashData();
            return true;
        }

        return false;
    }

    public function isStarted(): bool
    {
        return $this->started || session_status() === PHP_SESSION_ACTIVE;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $this->ensureStarted();
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        $this->ensureStarted();
        return array_key_exists($key, $_SESSION);
    }

    public function remove(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }

    public function flash(string $key, mixed $value): void
    {
        $this->ensureStarted();
        $_SESSION[self::FLASH_NEW_KEY][$key] = $value;
    }

    public function getFlash(string $key, mixed $default = null): mixed
    {
        $this->ensureStarted();
        return $_SESSION[self::FLASH_OLD_KEY][$key] ?? $_SESSION[self::FLASH_NEW_KEY][$key] ?? $default;
    }

    public function csrfToken(): string
    {
        $this->ensureStarted();
        $token = $_SESSION[self::CSRF_KEY] ?? null;

        if (!is_string($token) || strlen($token) < 32) {
            $token = bin2hex(random_bytes(32));
            $_SESSION[self::CSRF_KEY] = $token;
        }

        return $token;
    }

    public function rotateCsrfToken(): string
    {
        $this->ensureStarted();
        $token = bin2hex(random_bytes(32));
        $_SESSION[self::CSRF_KEY] = $token;
        return $token;
    }

    public function verifyCsrfToken(?string $token): bool
    {
        $this->ensureStarted();
        $expected = $_SESSION[self::CSRF_KEY] ?? '';
        if (!is_string($expected) || $expected === '' || !is_string($token) || $token === '') {
            return false;
        }

        return hash_equals($expected, $token);
    }

    public function regenerate(bool $deleteOldSession = true): bool
    {
        $this->ensureStarted();
        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
            return session_regenerate_id($deleteOldSession);
        }
        return true;
    }

    public function destroy(): void
    {
        $_SESSION = [];
        $this->started = false;

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            @session_destroy();
        }
    }

    private function ensureStarted(): void
    {
        if (!$this->isStarted()) {
            $this->start();
        }
    }

    private function enforceIdleLifetime(int $lifetimeSeconds): void
    {
        $now = time();
        $last = $_SESSION[self::LAST_ACTIVITY_KEY] ?? null;

        if (is_int($last) && ($now - $last) > $lifetimeSeconds) {
            $_SESSION = [];
            $this->regenerate(true);
        }

        $_SESSION[self::LAST_ACTIVITY_KEY] = $now;
    }

    private function cycleFlashData(): void
    {
        $previous = $_SESSION[self::FLASH_NEW_KEY] ?? [];
        $_SESSION[self::FLASH_OLD_KEY] = is_array($previous) ? $previous : [];
        $_SESSION[self::FLASH_NEW_KEY] = [];
    }
}

