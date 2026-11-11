<?php

declare(strict_types=1);

namespace App\Exceptions;

use Core\Exceptions\HttpException;

final class ValidationException extends HttpException
{
    /**
     * @param array<string, list<string>|string> $errors
     */
    public function __construct(
        private readonly array $errors,
        string $message = 'Submitted input failed validation.'
    ) {
        parent::__construct(422, $message);
    }

    /**
     * @return array<string, list<string>|string>
     */
    public function errors(): array
    {
        return $this->errors;
    }
}

