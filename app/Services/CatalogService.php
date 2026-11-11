<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Validators\CatalogQueryValidator;

/**
 * Catalog business service decoupling controllers from validation and repositories.
 */
final class CatalogService
{
    public function __construct(
        private readonly CategoryRepository $categories,
        private readonly ProductRepository $products,
        private readonly CatalogQueryValidator $validator
    ) {
    }

    /**
     * @return list<Category>
     */
    public function listCategories(): array
    {
        return $this->categories->findActiveAll();
    }

    /**
     * @param array<string, mixed> $query
     * @return array{filters:array<string, mixed>, categories:list<Category>, products:list<Product>}
     */
    public function browseProducts(array $query = []): array
    {
        $filters = $this->validator->validate($query);

        return [
            'filters' => $filters,
            'categories' => $this->categories->findActiveAll(),
            'products' => $this->products->findActive($filters),
        ];
    }

    /**
     * @return array{category:Category, products:list<Product>}
     */
    public function getCategoryCatalog(string $slug, array $query = []): array
    {
        $category = $this->categories->findActiveBySlug($slug);
        if ($category === null) {
            throw new ResourceNotFoundException('Category');
        }

        $filters = $this->validator->validate(array_merge($query, ['category' => $category->slug]));
        $products = $this->products->findActive($filters);

        return [
            'category' => $category,
            'products' => $products,
        ];
    }

    public function getProductBySlug(string $slug): Product
    {
        $product = $this->products->findActiveBySlug($slug);
        if ($product === null) {
            throw new ResourceNotFoundException('Product');
        }

        return $product;
    }
}

