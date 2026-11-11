<?php

declare(strict_types=1);

namespace App\Validators;

use App\Exceptions\ValidationException;

/**
 * Reusable base validator supporting centralized error accumulation.
 */
abstract class BaseValidator
{
    /** @var array<string, list<string>> */
    protected array $errors = [];

    /**
     * @param array<string, mixed> $input
     * @return array<string, mixed> Validated and normalized values
     */
    abstract public function validate(array $input): array;

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    protected function throwIfInvalid(): void
    {
        if ($this->errors !== []) {
            $errors = $this->errors;
            $this->errors = [];
            throw new ValidationException($errors);
        }
    }
}

