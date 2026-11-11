<?php

declare(strict_types=1);

namespace Core\Exceptions;

final class NotFoundException extends HttpException
{
    public function __construct(string $message = 'The requested resource could not be found.', ?\Throwable $previous = null)
    {
        parent::__construct(404, $message, [], $previous);
    }
}

