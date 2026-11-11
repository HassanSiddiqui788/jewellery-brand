<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;

/**
 * Repository for querying categories from jewels_db via prepared PDO statements.
 */
final class CategoryRepository extends BaseRepository
{
    /**
     * @return list<Category>
     */
    public function findActiveAll(): array
    {
        $sql = <<<'SQL'
            SELECT id, category_name, category_slug, category_image, description, status, created_at
            FROM categories
            WHERE status = :status
            ORDER BY id ASC
        SQL;

        $rows = $this->fetchAll($sql, [':status' => 'active']);
        return array_map(static fn (array $row): Category => Category::fromArray($row), $rows);
    }

    public function findActiveBySlug(string $slug): ?Category
    {
        $sql = <<<'SQL'
            SELECT id, category_name, category_slug, category_image, description, status, created_at
            FROM categories
            WHERE category_slug = :slug AND status = :status
            LIMIT 1
        SQL;

        $row = $this->fetchOne($sql, [
            ':slug' => $slug,
            ':status' => 'active',
        ]);

        return $row !== null ? Category::fromArray($row) : null;
    }
}

