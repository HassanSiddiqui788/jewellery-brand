<?php

declare(strict_types=1);

namespace Core\Middleware;

use Core\Contracts\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * Onion-style HTTP middleware execution pipeline.
 */
final class MiddlewarePipeline
{
    /** @var list<MiddlewareInterface|callable> */
    private array $middlewares = [];

    /**
     * @param list<MiddlewareInterface|callable> $middlewares
     */
    public function through(array $middlewares): self
    {
        $this->middlewares = array_values($middlewares);
        return $this;
    }

    /**
     * @param callable(Request): Response $destination
     */
    public function handle(Request $request, callable $destination): Response
    {
        $pipeline = array_reduce(
            array_reverse($this->middlewares),
            static function (callable $next, MiddlewareInterface|callable $middleware): callable {
                return static function (Request $req) use ($middleware, $next): Response {
                    if ($middleware instanceof MiddlewareInterface) {
                        return $middleware->handle($req, $next);
                    }
                    return $middleware($req, $next);
                };
            },
            $destination
        );

        return $pipeline($request);
    }
}

