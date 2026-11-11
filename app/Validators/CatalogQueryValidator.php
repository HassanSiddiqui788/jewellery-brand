<?php

declare(strict_types=1);

namespace App\Validators;

use Core\Helpers\Security;

/**
 * Validates catalog listing, search, and sorting query parameters.
 */
final class CatalogQueryValidator extends BaseValidator
{
    private const ALLOWED_SORTS = ['newest', 'price_asc', 'price_desc', 'name_asc'];

    /**
     * @param array<string, mixed> $input
     * @return array{category:?string, search:?string, sort:string, limit:int}
     */
    public function validate(array $input): array
    {
        $this->errors = [];

        $category = null;
        if (isset($input['category']) && $input['category'] !== '') {
            $rawCategory = (string) $input['category'];
            $slug = Security::sanitizeSlug($rawCategory);
            if ($slug === '' || strlen($slug) > 100) {
                $this->addError('category', 'Invalid category filter slug.');
            } else {
                $category = $slug;
            }
        }

        $search = null;
        if (isset($input['q']) && trim((string) $input['q']) !== '') {
            $search = Security::sanitizeString((string) $input['q'], 80);
        }

        $sort = strtolower(trim((string) ($input['sort'] ?? 'newest')));
        if (!in_array($sort, self::ALLOWED_SORTS, true)) {
            $this->addError('sort', 'Sort option must be one of: ' . implode(', ', self::ALLOWED_SORTS) . '.');
        }

        $limitRaw = $input['limit'] ?? 24;
        $limit = Security::sanitizeInt($limitRaw, -1);
        if ($limit < 1 || $limit > 100) {
            $this->addError('limit', 'Limit must be an integer between 1 and 100.');
        }

        $this->throwIfInvalid();

        return [
            'category' => $category,
            'search' => $search,
            'sort' => $sort,
            'limit' => $limit,
        ];
    }
}

