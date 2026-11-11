<?php

declare(strict_types=1);

namespace Core\Middleware;

use Core\Contracts\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Session\SessionManager;

/**
 * Starts hardened session infrastructure for web requests (without authentication logic in Phase 1).
 */
final class SessionMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly SessionManager $session)
    {
    }

    public function handle(Request $request, callable $next): Response
    {
        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        return $next($request);
    }
}

