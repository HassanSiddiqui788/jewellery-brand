<?php

declare(strict_types=1);

use App\Controllers\CatalogController;
use App\Controllers\HealthController;
use App\Controllers\HomeController;
use Core\Router\Router;

return static function (Router $router): void {
    $router->get('/', [HomeController::class, 'index'])->name('home');
    $router->get('/health', [HealthController::class, 'status'])->name('health.status');

    $router->get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    $router->get('/catalog/category/{slug}', [CatalogController::class, 'category'])->name('catalog.category');
    $router->get('/catalog/product/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
};

