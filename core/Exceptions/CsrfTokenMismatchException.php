<?php

declare(strict_types=1);

namespace Core\Exceptions;

final class CsrfTokenMismatchException extends HttpException
{
    public function __construct(string $message = 'CSRF security token validation failed or expired.')
    {
        parent::__construct(419, $message);
    }
}

