<?php

declare(strict_types=1);

namespace Core\Exceptions;

final class DatabaseConnectionException extends \RuntimeException
{
    public function __construct(string $message = 'Database service is currently unavailable.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

