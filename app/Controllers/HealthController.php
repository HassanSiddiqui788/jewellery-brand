<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\HealthService;
use Core\Http\Request;
use Core\Http\Response;
use Core\Session\SessionManager;

/**
 * Handles application and database readiness endpoints without leaking credentials.
 */
final class HealthController extends BaseController
{
    public function __construct(
        SessionManager $session,
        private readonly HealthService $healthService
    ) {
        parent::__construct($session);
    }

    public function status(Request $request): Response
    {
        $snapshot = $this->healthService->snapshot();
        $httpStatus = $snapshot['database']['connected'] ? 200 : 503;

        if ($request->wantsJson()) {
            return $this->json([
                'ok' => $snapshot['database']['connected'],
                'data' => $snapshot,
            ], $httpStatus);
        }

        return $this->view('health/status', ['snapshot' => $snapshot], $httpStatus);
    }

    public function apiStatus(Request $request): Response
    {
        $snapshot = $this->healthService->snapshot();
        $httpStatus = $snapshot['database']['connected'] ? 200 : 503;

        return $this->json([
            'ok' => $snapshot['database']['connected'],
            'data' => $snapshot,
        ], $httpStatus);
    }
}

