<?php

declare(strict_types=1);

namespace Core\Exceptions;

final class MethodNotAllowedException extends HttpException
{
    /** @var list<string> */
    private array $allowedMethods;

    /**
     * @param list<string> $allowedMethods
     */
    public function __construct(array $allowedMethods, string $message = 'HTTP method not allowed for this route.')
    {
        $this->allowedMethods = array_values(array_unique(array_map('strtoupper', $allowedMethods)));
        $headers = ['Allow' => implode(', ', $this->allowedMethods)];
        parent::__construct(405, $message, $headers);
    }

    /**
     * @return list<string>
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }
}

