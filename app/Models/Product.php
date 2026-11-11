<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Pure Product domain model (no SQL/database dependency inside entity).
 */
final class Product
{
    public function __construct(
        public readonly int $id,
        public readonly int $categoryId,
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $description,
        public readonly float $price,
        public readonly ?float $discountPrice,
        public readonly ?string $mainImage,
        public readonly int $stockQuantity,
        public readonly string $status = 'active',
        public readonly ?string $categoryName = null,
        public readonly ?string $categorySlug = null,
        public readonly ?string $createdAt = null
    ) {
    }

    /**
     * @param array<string, mixed> $row
     */
    public static function fromArray(array $row): self
    {
        $discount = isset($row['discount_price']) && $row['discount_price'] !== null && $row['discount_price'] !== ''
            ? (float) $row['discount_price']
            : null;

        return new self(
            id: (int) ($row['id'] ?? 0),
            categoryId: (int) ($row['category_id'] ?? 0),
            name: (string) ($row['product_name'] ?? $row['name'] ?? ''),
            slug: (string) ($row['product_slug'] ?? $row['slug'] ?? ''),
            description: isset($row['description']) ? (string) $row['description'] : null,
            price: (float) ($row['price'] ?? 0.0),
            discountPrice: $discount,
            mainImage: isset($row['main_image']) ? (string) $row['main_image'] : null,
            stockQuantity: (int) ($row['stock_quantity'] ?? 0),
            status: (string) ($row['status'] ?? 'active'),
            categoryName: isset($row['category_name']) ? (string) $row['category_name'] : null,
            categorySlug: isset($row['category_slug']) ? (string) $row['category_slug'] : null,
            createdAt: isset($row['created_at']) ? (string) $row['created_at'] : null,
        );
    }

    public function effectivePrice(): float
    {
        if ($this->discountPrice !== null && $this->discountPrice > 0 && $this->discountPrice < $this->price) {
            return $this->discountPrice;
        }

        return $this->price;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->categoryId,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discountPrice,
            'effective_price' => $this->effectivePrice(),
            'main_image' => $this->mainImage,
            'stock_quantity' => $this->stockQuantity,
            'status' => $this->status,
            'category_name' => $this->categoryName,
            'category_slug' => $this->categorySlug,
            'created_at' => $this->createdAt,
        ];
    }
}

