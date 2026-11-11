<?php

declare(strict_types=1);

namespace Core\Router;

/**
 * Represents a single registered HTTP route with parameter matching, naming, and middleware.
 */
final class Route
{
    private ?string $name = null;

    /** @var list<string> */
    private array $middlewares = [];

    /** @var list<string> */
    private array $methods;

    private string $pattern;
    private mixed $handler;

    /**
     * @param list<string> $methods
     * @param list<string> $middlewares
     */
    public function __construct(
        array $methods,
        string $pattern,
        mixed $handler,
        array $middlewares = []
    ) {
        $normalized = [];
        foreach ($methods as $method) {
            $upper = strtoupper($method);
            $normalized[] = $upper;
            if ($upper === 'GET') {
                $normalized[] = 'HEAD';
            }
        }

        $this->methods = array_values(array_unique($normalized));
        $this->pattern = $this->normalizePattern($pattern);
        $this->handler = $handler;
        $this->middlewares = array_values($middlewares);
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string|list<string> $middleware
     */
    public function middleware(string|array $middleware): self
    {
        $items = is_array($middleware) ? $middleware : [$middleware];
        foreach ($items as $item) {
            $this->middlewares[] = $item;
        }
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return list<string>
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public function supportsMethod(string $method): bool
    {
        return in_array(strtoupper($method), $this->methods, true);
    }

    public function getHandler(): mixed
    {
        return $this->handler;
    }

    /**
     * @return list<string>
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * Match path against route pattern, extracting named {param} or {param:regex} segments.
     *
     * @param array<string, string>|null $params
     */
    public function matchesPath(string $path, ?array &$params = null): bool
    {
        $params = [];
        $regex = $this->compileRegex();

        if (preg_match($regex, $path, $matches) !== 1) {
            return false;
        }

        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $params[$key] = urldecode($value);
            }
        }

        return true;
    }

    /**
     * Build concrete URL path for this named route by substituting parameters.
     *
     * @param array<string, scalar> $params
     */
    public function buildUrl(array $params = []): string
    {
        $missing = [];
        $built = preg_replace_callback('/\{([A-Za-z_][A-Za-z0-9_]*)(?::[^}]+)?\}/', static function (array $m) use ($params, &$missing): string {
            $key = $m[1];
            if (!array_key_exists($key, $params)) {
                $missing[] = $key;
                return $m[0];
            }
            return rawurlencode((string) $params[$key]);
        }, $this->pattern);

        if ($missing !== []) {
            throw new \InvalidArgumentException(sprintf('Missing route parameters [%s] for pattern "%s".', implode(', ', $missing), $this->pattern));
        }

        return $built ?? $this->pattern;
    }

    private function compileRegex(): string
    {
        $pattern = preg_replace_callback(
            '/\{([A-Za-z_][A-Za-z0-9_]*)(?::([^}]+))?\}/',
            static function (array $m): string {
                $name = $m[1];
                $constraint = $m[2] ?? '[^/]+';
                return '(?P<' . $name . '>' . $constraint . ')';
            },
            $this->pattern
        );

        return '#^' . $pattern . '$#';
    }

    private function normalizePattern(string $pattern): string
    {
        $trimmed = '/' . ltrim($pattern, '/');
        return $trimmed === '/' ? '/' : rtrim($trimmed, '/');
    }
}

