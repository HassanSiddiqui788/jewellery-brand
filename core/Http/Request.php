<?php

declare(strict_types=1);

namespace Core\Http;

/**
 * Immutable-friendly HTTP request abstraction supporting globals capture or isolated instantiation.
 */
final class Request
{
    private string $method;
    private string $path;

    /** @var array<string, mixed> */
    private array $query;

    /** @var array<string, mixed> */
    private array $body;

    /** @var array<string, string> */
    private array $headers;

    /** @var array<string, string> */
    private array $cookies;

    /** @var array<string, mixed> */
    private array $server;

    /** @var array<string, string> */
    private array $routeParams = [];

    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $body
     * @param array<string, string> $headers
     * @param array<string, string> $cookies
     * @param array<string, mixed> $server
     */
    public function __construct(
        string $method = 'GET',
        string $path = '/',
        array $query = [],
        array $body = [],
        array $headers = [],
        array $cookies = [],
        array $server = []
    ) {
        $this->headers = self::normalizeHeaders($headers);
        $this->method = self::resolveMethod($method, $body, $this->headers);
        $this->path = self::normalizePath($path);
        $this->query = $query;
        $this->body = $body;
        $this->cookies = $cookies;
        $this->server = $server;
    }

    public static function capture(): self
    {
        $method = (string) ($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $rawUri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
        $uriPath = (string) (parse_url($rawUri, PHP_URL_PATH) ?: '/');

        // Strip /public prefix cleanly when Apache/XAMPP routes through /project/public/index.php
        $scriptName = (string) ($_SERVER['SCRIPT_NAME'] ?? '');
        $scriptDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
        if ($scriptDir !== '' && $scriptDir !== '/' && str_starts_with($uriPath, $scriptDir)) {
            $uriPath = substr($uriPath, strlen($scriptDir)) ?: '/';
        } elseif ($scriptDir !== '' && str_ends_with($scriptDir, '/public')) {
            $baseDir = rtrim(substr($scriptDir, 0, -7), '/');
            if ($baseDir !== '' && str_starts_with($uriPath, $baseDir)) {
                $uriPath = substr($uriPath, strlen($baseDir)) ?: '/';
            }
        }

        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (!is_string($value)) {
                continue;
            }
            if (str_starts_with($key, 'HTTP_')) {
                $name = str_replace('_', '-', substr($key, 5));
                $headers[$name] = $value;
            } elseif (in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH'], true)) {
                $headers[str_replace('_', '-', $key)] = $value;
            }
        }

        $body = $_POST;
        $contentType = strtolower($headers['CONTENT-TYPE'] ?? '');
        if ($body === [] && str_contains($contentType, 'application/json')) {
            $rawInput = file_get_contents('php://input');
            if (is_string($rawInput) && $rawInput !== '') {
                $decoded = json_decode($rawInput, true);
                if (is_array($decoded)) {
                    $body = $decoded;
                }
            }
        }

        return new self($method, $uriPath, $_GET, $body, $headers, $_COOKIE, $_SERVER);
    }

    public function method(): string
    {
        return $this->method;
    }

    public function isMethod(string $method): bool
    {
        return $this->method === strtoupper($method);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function queryAll(): array
    {
        return $this->query;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return array_merge($this->query, $this->body);
    }

    public function header(string $name, ?string $default = null): ?string
    {
        $normalized = strtoupper(str_replace('_', '-', $name));
        return $this->headers[$normalized] ?? $default;
    }

    public function cookie(string $name, ?string $default = null): ?string
    {
        return $this->cookies[$name] ?? $default;
    }

    public function wantsJson(): bool
    {
        if (str_starts_with($this->path, '/api/')) {
            return true;
        }

        $accept = strtolower((string) $this->header('Accept', ''));
        return str_contains($accept, 'application/json');
    }

    public function isAjax(): bool
    {
        return strtolower((string) $this->header('X-Requested-With', '')) === 'xmlhttprequest';
    }

    public function isSecure(): bool
    {
        $https = strtolower((string) ($this->server['HTTPS'] ?? ''));
        if ($https !== '' && $https !== 'off') {
            return true;
        }
        $forwardedProto = strtolower((string) $this->header('X-Forwarded-Proto', ''));
        return $forwardedProto === 'https';
    }

    public function clientIp(): string
    {
        $ip = $this->server['REMOTE_ADDR'] ?? '127.0.0.1';
        return is_string($ip) && filter_var($ip, FILTER_VALIDATE_IP) !== false ? $ip : '127.0.0.1';
    }

    /**
     * @param array<string, string> $params
     */
    public function withRouteParams(array $params): self
    {
        $clone = clone $this;
        $clone->routeParams = $params;
        return $clone;
    }

    public function routeParam(string $name, ?string $default = null): ?string
    {
        return $this->routeParams[$name] ?? $default;
    }

    /**
     * @return array<string, string>
     */
    public function routeParams(): array
    {
        return $this->routeParams;
    }

    /**
     * @param array<string, mixed> $body
     * @param array<string, string> $headers
     */
    private static function resolveMethod(string $method, array $body, array $headers): string
    {
        $upper = strtoupper($method);
        if ($upper !== 'POST') {
            return $upper;
        }

        $override = $body['_method'] ?? $headers['X-HTTP-METHOD-OVERRIDE'] ?? null;
        if (is_string($override)) {
            $candidate = strtoupper(trim($override));
            if (in_array($candidate, ['PUT', 'PATCH', 'DELETE'], true)) {
                return $candidate;
            }
        }

        return $upper;
    }

    /**
     * @param array<string, string> $headers
     * @return array<string, string>
     */
    private static function normalizeHeaders(array $headers): array
    {
        $normalized = [];
        foreach ($headers as $key => $value) {
            $normalized[strtoupper(str_replace('_', '-', (string) $key))] = (string) $value;
        }
        return $normalized;
    }

    private static function normalizePath(string $path): string
    {
        $clean = (string) (parse_url($path, PHP_URL_PATH) ?: $path);
        $clean = '/' . ltrim($clean, '/');
        return $clean === '/' ? '/' : rtrim($clean, '/');
    }
}

