<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\CatalogService;
use Core\Config\ConfigRepository;
use Core\Http\Request;
use Core\Http\Response;
use Core\Session\SessionManager;

/**
 * Front-controller home handler for routed HTTP entrypoints.
 */
final class HomeController extends BaseController
{
    public function __construct(
        SessionManager $session,
        private readonly ConfigRepository $config,
        private readonly CatalogService $catalogService
    ) {
        parent::__construct($session);
    }

    public function index(Request $request): Response
    {
        if ($request->wantsJson()) {
            return $this->json([
                'ok' => true,
                'app' => (string) $this->config->get('app.name', 'Lorem Ipsum'),
                'tagline' => (string) $this->config->get('app.tagline', ''),
                'csrf_token' => $this->session->csrfToken(),
            ]);
        }

        $categories = [];
        try {
            $categories = $this->catalogService->listCategories();
        } catch (\Throwable) {
            // Preserve home availability if database daemon or tables are not initialized yet
            $categories = [];
        }

        return $this->view('home/index', [
            'title' => (string) $this->config->get('app.name', 'Lorem Ipsum'),
            'tagline' => (string) $this->config->get('app.tagline', ''),
            'categories' => $categories,
        ]);
    }
}

