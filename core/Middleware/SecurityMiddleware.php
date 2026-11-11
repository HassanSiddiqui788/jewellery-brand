<?php

declare(strict_types=1);

namespace Core\Middleware;

use Core\Contracts\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * Applies defensive HTTP security headers consistently across all routed responses.
 */
final class SecurityMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        $response = $next($request);

        $defaults = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
            'X-XSS-Protection' => '0',
        ];

        foreach ($defaults as $header => $value) {
            if ($response->getHeader($header) === null) {
                $response = $response->withHeader($header, $value);
            }
        }

        return $response;
    }
}

