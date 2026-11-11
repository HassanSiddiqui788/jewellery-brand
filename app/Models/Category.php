<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Pure Category domain model (no SQL/database dependency inside entity).
 */
final class Category
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $image = null,
        public readonly ?string $description = null,
        public readonly string $status = 'active',
        public readonly ?string $createdAt = null
    ) {
    }

    /**
     * @param array<string, mixed> $row
     */
    public static function fromArray(array $row): self
    {
        return new self(
            id: (int) ($row['id'] ?? 0),
            name: (string) ($row['category_name'] ?? $row['name'] ?? ''),
            slug: (string) ($row['category_slug'] ?? $row['slug'] ?? ''),
            image: isset($row['category_image']) ? (string) $row['category_image'] : null,
            description: isset($row['description']) ? (string) $row['description'] : null,
            status: (string) ($row['status'] ?? 'active'),
            createdAt: isset($row['created_at']) ? (string) $row['created_at'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->createdAt,
        ];
    }
}

