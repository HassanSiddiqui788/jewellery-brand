<?php

declare(strict_types=1);

namespace Core\Middleware;

use Core\Contracts\MiddlewareInterface;
use Core\Exceptions\CsrfTokenMismatchException;
use Core\Http\Request;
use Core\Http\Response;
use Core\Session\SessionManager;

/**
 * Verifies CSRF tokens on state-changing web requests (POST, PUT, PATCH, DELETE).
 */
final class CsrfMiddleware implements MiddlewareInterface
{
    private const WRITE_METHODS = ['POST', 'PUT', 'PATCH', 'DELETE'];

    public function __construct(private readonly SessionManager $session)
    {
    }

    public function handle(Request $request, callable $next): Response
    {
        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        if (in_array($request->method(), self::WRITE_METHODS, true)) {
            $submitted = $request->input('_token');
            if (!is_string($submitted) || $submitted === '') {
                $submitted = $request->header('X-CSRF-TOKEN');
            }

            if (!$this->session->verifyCsrfToken(is_string($submitted) ? $submitted : null)) {
                throw new CsrfTokenMismatchException();
            }
        }

        return $next($request);
    }
}

