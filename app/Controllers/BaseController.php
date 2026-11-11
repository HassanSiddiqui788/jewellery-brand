<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Http\Response;
use Core\Session\SessionManager;

/**
 * Base controller providing consistent view rendering and JSON serialization helpers.
 */
abstract class BaseController
{
    public function __construct(protected readonly SessionManager $session)
    {
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function view(string $template, array $data = [], int $status = 200): Response
    {
        $data['csrfToken'] = $this->session->csrfToken();
        return Response::view($template, $data, $status);
    }

    protected function json(mixed $data, int $status = 200): Response
    {
        return Response::json($data, $status);
    }
}

