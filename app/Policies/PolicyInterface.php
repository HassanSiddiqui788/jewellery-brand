<?php

declare(strict_types=1);

namespace App\Policies;

/**
 * Authorization policy contract reserved for Phase 2+ role/ownership checks.
 * No user authentication or role enforcement is active in Phase 1.
 */
interface PolicyInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function allows(string $ability, mixed $subject = null, array $context = []): bool;
}

