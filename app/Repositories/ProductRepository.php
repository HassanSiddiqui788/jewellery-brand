<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;

/**
 * Repository for querying products from jewels_db via prepared PDO statements.
 */
final class ProductRepository extends BaseRepository
{
    /**
     * @param array{category?:?string, search?:?string, sort?:string, limit?:int} $filters
     * @return list<Product>
     */
    public function findActive(array $filters = []): array
    {
        $conditions = ['p.status = :status'];
        $params = [':status' => 'active'];

        if (!empty($filters['category'])) {
            $conditions[] = 'c.category_slug = :category_slug';
            $params[':category_slug'] = (string) $filters['category'];
        }

        if (!empty($filters['search'])) {
            $conditions[] = '(p.product_name LIKE :search_name OR p.description LIKE :search_desc)';
            $searchTerm = '%' . (string) $filters['search'] . '%';
            $params[':search_name'] = $searchTerm;
            $params[':search_desc'] = $searchTerm;
        }

        $orderSql = match ($filters['sort'] ?? 'newest') {
            'price_asc' => 'COALESCE(NULLIF(p.discount_price, 0), p.price) ASC, p.id DESC',
            'price_desc' => 'COALESCE(NULLIF(p.discount_price, 0), p.price) DESC, p.id DESC',
            'name_asc' => 'p.product_name ASC, p.id DESC',
            default => 'p.id DESC',
        };

        $limit = max(1, min(100, (int) ($filters['limit'] ?? 24)));
        $whereSql = implode(' AND ', $conditions);

        $sql = <<<SQL
            SELECT
                p.id,
                p.category_id,
                p.product_name,
                p.product_slug,
                p.description,
                p.price,
                p.discount_price,
                p.main_image,
                p.stock_quantity,
                p.status,
                p.created_at,
                c.category_name,
                c.category_slug
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE {$whereSql}
            ORDER BY {$orderSql}
            LIMIT :limit
        SQL;

        $stmt = $this->connection->pdo()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, \PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        return array_map(static fn (array $row): Product => Product::fromArray($row), is_array($rows) ? $rows : []);
    }

    public function findActiveBySlug(string $slug): ?Product
    {
        $sql = <<<'SQL'
            SELECT
                p.id,
                p.category_id,
                p.product_name,
                p.product_slug,
                p.description,
                p.price,
                p.discount_price,
                p.main_image,
                p.stock_quantity,
                p.status,
                p.created_at,
                c.category_name,
                c.category_slug
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.product_slug = :slug AND p.status = :status
            LIMIT 1
        SQL;

        $row = $this->fetchOne($sql, [
            ':slug' => $slug,
            ':status' => 'active',
        ]);

        return $row !== null ? Product::fromArray($row) : null;
    }
}

