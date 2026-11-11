<?php

declare(strict_types=1);

namespace Core\Http;

/**
 * Structured HTTP Response with JSON, HTML, redirect, and view template helpers.
 */
final class Response
{
    /** @var array<string, string> */
    private array $headers;

    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private string $content = '',
        private int $statusCode = 200,
        array $headers = []
    ) {
        $this->headers = $headers;
    }

    /**
     * @param array<string, string> $headers
     */
    public static function html(string $html, int $status = 200, array $headers = []): self
    {
        $headers['Content-Type'] = $headers['Content-Type'] ?? 'text/html; charset=UTF-8';
        return new self($html, $status, $headers);
    }

    /**
     * @param array<string, string> $headers
     */
    public static function text(string $text, int $status = 200, array $headers = []): self
    {
        $headers['Content-Type'] = $headers['Content-Type'] ?? 'text/plain; charset=UTF-8';
        return new self($text, $status, $headers);
    }

    /**
     * @param array<string, string> $headers
     */
    public static function json(mixed $data, int $status = 200, array $headers = []): self
    {
        $headers['Content-Type'] = $headers['Content-Type'] ?? 'application/json; charset=UTF-8';
        $encoded = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        return new self($encoded, $status, $headers);
    }

    public static function redirect(string $location, int $status = 302): self
    {
        return new self('', $status, ['Location' => $location]);
    }

    /**
     * Render a PHP view template from resources/views safely with isolated variable scope.
     *
     * @param array<string, mixed> $data
     * @param array<string, string> $headers
     */
    public static function view(string $viewName, array $data = [], int $status = 200, array $headers = []): self
    {
        $viewsDir = rtrim((string) config('app.paths.views', base_path('resources/views')), '/\\');
        $relative = str_replace(['.', '..'], ['/', ''], $viewName);
        $file = $viewsDir . '/' . ltrim($relative, '/') . '.php';

        if (!is_file($file)) {
            throw new \RuntimeException(sprintf('View template "%s" not found.', $viewName));
        }

        $renderer = static function (string $__templateFile, array $__templateData): string {
            extract($__templateData, EXTR_SKIP);
            ob_start();
            try {
                require $__templateFile;
                return (string) ob_get_clean();
            } catch (\Throwable $e) {
                ob_end_clean();
                throw $e;
            }
        };

        return self::html($renderer($file, $data), $status, $headers);
    }

    public function withHeader(string $name, string $value): self
    {
        $clone = clone $this;
        $clone->headers[$name] = $value;
        return $clone;
    }

    public function withStatus(int $statusCode): self
    {
        $clone = clone $this;
        $clone->statusCode = $statusCode;
        return $clone;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name): ?string
    {
        foreach ($this->headers as $k => $v) {
            if (strcasecmp($k, $name) === 0) {
                return $v;
            }
        }
        return null;
    }

    public function send(): void
    {
        if (!headers_sent()) {
            http_response_code($this->statusCode);
            foreach ($this->headers as $name => $value) {
                header($name . ': ' . $value);
            }
        }

        echo $this->content;
    }
}

