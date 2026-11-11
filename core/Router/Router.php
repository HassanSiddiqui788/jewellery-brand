<?php

declare(strict_types=1);

namespace Core\Router;

use Core\Contracts\MiddlewareInterface;
use Core\Exceptions\MethodNotAllowedException;
use Core\Exceptions\NotFoundException;
use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware\MiddlewarePipeline;
use Core\Middleware\MiddlewareRegistry;

/**
 * Modular HTTP router supporting REST verbs, parameters, route groups, named routes,
 * middleware pipelines, and explicit 404/405 differentiation.
 */
final class Router
{
    /** @var list<Route> */
    private array $routes = [];

    /** @var array<int, array{prefix:string, middleware:list<string>}> */
    private array $groupStack = [];

    /** @var list<string|MiddlewareInterface> */
    private array $globalMiddleware = [];

    /**
     * @param callable(mixed, Request): Response|null $handlerInvoker
     */
    public function __construct(
        private readonly MiddlewareRegistry $middlewareRegistry,
        private readonly mixed $handlerInvoker = null
    ) {
    }

    /**
     * @param list<string|MiddlewareInterface> $middlewares
     */
    public function pushGlobalMiddleware(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            $this->globalMiddleware[] = $middleware;
        }
    }

    public function get(string $pattern, mixed $handler): Route
    {
        return $this->add(['GET'], $pattern, $handler);
    }

    public function post(string $pattern, mixed $handler): Route
    {
        return $this->add(['POST'], $pattern, $handler);
    }

    public function put(string $pattern, mixed $handler): Route
    {
        return $this->add(['PUT'], $pattern, $handler);
    }

    public function patch(string $pattern, mixed $handler): Route
    {
        return $this->add(['PATCH'], $pattern, $handler);
    }

    public function delete(string $pattern, mixed $handler): Route
    {
        return $this->add(['DELETE'], $pattern, $handler);
    }

    /**
     * @param list<string> $methods
     */
    public function match(array $methods, string $pattern, mixed $handler): Route
    {
        return $this->add($methods, $pattern, $handler);
    }

    /**
     * @param array{prefix?:string, middleware?:string|list<string>} $attributes
     * @param callable(self): void $callback
     */
    public function group(array $attributes, callable $callback): void
    {
        $prefix = trim((string) ($attributes['prefix'] ?? ''), '/');
        $mwRaw = $attributes['middleware'] ?? [];
        $mwList = is_array($mwRaw) ? $mwRaw : [$mwRaw];

        $this->groupStack[] = [
            'prefix' => $prefix,
            'middleware' => array_values($mwList),
        ];

        try {
            $callback($this);
        } finally {
            array_pop($this->groupStack);
        }
    }

    public function dispatch(Request $request): Response
    {
        $path = $request->path();
        $method = $request->method();

        $allowedForPath = [];

        foreach ($this->routes as $route) {
            $params = [];
            if (!$route->matchesPath($path, $params)) {
                continue;
            }

            if ($route->supportsMethod($method)) {
                $routedRequest = $request->withRouteParams($params);
                return $this->runRoute($route, $routedRequest);
            }

            foreach ($route->getMethods() as $supported) {
                $allowedForPath[] = $supported;
            }
        }

        if ($allowedForPath !== []) {
            throw new MethodNotAllowedException($allowedForPath);
        }

        throw new NotFoundException(sprintf('No route matched "%s".', $path));
    }

    /**
     * Generate URI path for a named route.
     *
     * @param array<string, scalar> $params
     */
    public function url(string $name, array $params = []): string
    {
        foreach ($this->routes as $route) {
            if ($route->getName() === $name) {
                return $route->buildUrl($params);
            }
        }

        throw new \InvalidArgumentException(sprintf('Named route "%s" is not registered.', $name));
    }

    /**
     * @return list<Route>
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param list<string> $methods
     */
    private function add(array $methods, string $pattern, mixed $handler): Route
    {
        $prefixParts = [];
        $groupMiddlewares = [];

        foreach ($this->groupStack as $group) {
            if ($group['prefix'] !== '') {
                $prefixParts[] = $group['prefix'];
            }
            foreach ($group['middleware'] as $mw) {
                $groupMiddlewares[] = $mw;
            }
        }

        $trimmedPattern = trim($pattern, '/');
        if ($trimmedPattern !== '') {
            $prefixParts[] = $trimmedPattern;
        }

        $fullPattern = '/' . implode('/', $prefixParts);
        $route = new Route($methods, $fullPattern, $handler, $groupMiddlewares);
        $this->routes[] = $route;

        return $route;
    }

    private function runRoute(Route $route, Request $request): Response
    {
        $stack = $this->middlewareRegistry->resolve(
            array_merge($this->globalMiddleware, $route->getMiddlewares())
        );

        $destination = function (Request $req) use ($route): Response {
            $result = $this->invokeHandler($route->getHandler(), $req);
            if ($result instanceof Response) {
                return $result;
            }
            if (is_array($result)) {
                return Response::json($result);
            }
            return Response::html((string) $result);
        };

        return (new MiddlewarePipeline())
            ->through($stack)
            ->handle($request, $destination);
    }

    private function invokeHandler(mixed $handler, Request $request): mixed
    {
        if ($this->handlerInvoker !== null) {
            return ($this->handlerInvoker)($handler, $request);
        }

        if (is_array($handler) && count($handler) === 2 && is_string($handler[0])) {
            $controller = new $handler[0]();
            $method = $handler[1];
            return $controller->{$method}($request);
        }

        if (is_callable($handler)) {
            return $handler($request);
        }

        throw new \RuntimeException('Route handler is not callable.');
    }
}

