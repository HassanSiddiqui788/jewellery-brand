<?php

declare(strict_types=1);

namespace Core\Exceptions;

class HttpException extends \RuntimeException
{
    /** @var array<string, string> */
    private array $headers;

    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly int $statusCode,
        string $message = '',
        array $headers = [],
        ?\Throwable $previous = null
    ) {
        $this->headers = $headers;
        parent::__construct($message, $statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}

