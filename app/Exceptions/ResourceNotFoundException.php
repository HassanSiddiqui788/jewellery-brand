<?php

declare(strict_types=1);

namespace App\Exceptions;

use Core\Exceptions\HttpException;

final class ResourceNotFoundException extends HttpException
{
    public function __construct(string $resource = 'Resource')
    {
        parent::__construct(404, sprintf('%s could not be found.', $resource));
    }
}

