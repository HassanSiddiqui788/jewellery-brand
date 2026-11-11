<?php

declare(strict_types=1);

use App\Controllers\CatalogController;
use App\Controllers\HealthController;
use Core\Router\Router;

return static function (Router $router): void {
    $router->get('/health', [HealthController::class, 'apiStatus'])->name('api.health');
    $router->get('/categories', [CatalogController::class, 'apiCategories'])->name('api.categories.index');
    $router->get('/products', [CatalogController::class, 'apiProducts'])->name('api.products.index');
};

