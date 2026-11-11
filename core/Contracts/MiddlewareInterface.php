<?php

declare(strict_types=1);

namespace Core\Contracts;

use Core\Http\Request;
use Core\Http\Response;

/**
 * Contract for HTTP request/response middleware handlers.
 * Future auth, role/policy authorization, and rate-limiting middleware implement this interface.
 */
interface MiddlewareInterface
{
    /**
     * @param callable(Request): Response $next
     */
    public function handle(Request $request, callable $next): Response;
}

