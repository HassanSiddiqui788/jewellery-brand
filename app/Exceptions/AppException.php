<?php

declare(strict_types=1);

namespace App\Exceptions;

use Core\Exceptions\HttpException;

class AppException extends HttpException
{
    public function __construct(string $message = 'Application error', int $statusCode = 500, ?\Throwable $previous = null)
    {
        parent::__construct($statusCode, $message, [], $previous);
    }
}

