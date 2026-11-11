<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CatalogService;
use Core\Http\Request;
use Core\Http\Response;
use Core\Session\SessionManager;

/**
 * Handles routed storefront catalog & API endpoints via CatalogService.
 */
final class CatalogController extends BaseController
{
    public function __construct(
        SessionManager $session,
        private readonly CatalogService $catalogService
    ) {
        parent::__construct($session);
    }

    public function index(Request $request): Response
    {
        $result = $this->catalogService->browseProducts($request->queryAll());

        if ($request->wantsJson()) {
            return $this->json([
                'ok' => true,
                'filters' => $result['filters'],
                'categories' => array_map(static fn (Category $c): array => $c->toArray(), $result['categories']),
                'products' => array_map(static fn (Product $p): array => $p->toArray(), $result['products']),
            ]);
        }

        return $this->view('catalog/index', [
            'title' => 'Jewelry Catalog',
            'filters' => $result['filters'],
            'categories' => $result['categories'],
            'products' => $result['products'],
        ]);
    }

    public function category(Request $request): Response
    {
        $slug = (string) $request->routeParam('slug', '');
        $result = $this->catalogService->getCategoryCatalog($slug, $request->queryAll());

        if ($request->wantsJson()) {
            return $this->json([
                'ok' => true,
                'category' => $result['category']->toArray(),
                'products' => array_map(static fn (Product $p): array => $p->toArray(), $result['products']),
            ]);
        }

        return $this->view('catalog/index', [
            'title' => $result['category']->name,
            'activeCategory' => $result['category'],
            'categories' => $this->catalogService->listCategories(),
            'products' => $result['products'],
            'filters' => ['category' => $slug],
        ]);
    }

    public function show(Request $request): Response
    {
        $slug = (string) $request->routeParam('slug', '');
        $product = $this->catalogService->getProductBySlug($slug);

        if ($request->wantsJson()) {
            return $this->json([
                'ok' => true,
                'product' => $product->toArray(),
            ]);
        }

        return $this->view('catalog/show', [
            'title' => $product->name,
            'product' => $product,
        ]);
    }

    public function apiCategories(Request $request): Response
    {
        $categories = $this->catalogService->listCategories();

        return $this->json([
            'ok' => true,
            'data' => array_map(static fn (Category $c): array => $c->toArray(), $categories),
        ]);
    }

    public function apiProducts(Request $request): Response
    {
        $result = $this->catalogService->browseProducts($request->queryAll());

        return $this->json([
            'ok' => true,
            'filters' => $result['filters'],
            'data' => array_map(static fn (Product $p): array => $p->toArray(), $result['products']),
        ]);
    }
}

