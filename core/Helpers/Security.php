<?php

declare(strict_types=1);

namespace Core\Helpers;

/**
 * Output escaping, input sanitization, and path safety helpers.
 */
final class Security
{
    public static function escapeHtml(mixed $value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function escapeAttr(mixed $value): string
    {
        return self::escapeHtml($value);
    }

    public static function escapeUrl(string $url): string
    {
        $trimmed = trim($url);
        if ($trimmed === '') {
            return '';
        }

        // Reject dangerous URI schemes such as javascript:, data:, vbscript:
        if (preg_match('/^\s*(javascript|vbscript|data):/i', $trimmed) === 1) {
            return '#';
        }

        return self::escapeHtml($trimmed);
    }

    public static function sanitizeString(?string $value, int $maxLength = 255): string
    {
        $clean = trim(strip_tags((string) ($value ?? '')));
        $clean = preg_replace('/[\x00-\x1F\x7F]/u', '', $clean) ?? $clean;

        if ($maxLength > 0 && mb_strlen($clean, 'UTF-8') > $maxLength) {
            return mb_substr($clean, 0, $maxLength, 'UTF-8');
        }

        return $clean;
    }

    public static function sanitizeSlug(?string $value): string
    {
        $clean = strtolower(trim((string) ($value ?? '')));
        $clean = preg_replace('/[^a-z0-9-]+/', '-', $clean) ?? '';
        return trim($clean, '-');
    }

    public static function sanitizeInt(mixed $value, int $default = 0): int
    {
        $filtered = filter_var($value, FILTER_VALIDATE_INT);
        return $filtered !== false ? (int) $filtered : $default;
    }

    public static function sanitizeFloat(mixed $value, float $default = 0.0): float
    {
        $filtered = filter_var($value, FILTER_VALIDATE_FLOAT);
        return $filtered !== false ? (float) $filtered : $default;
    }

    /**
     * Format currency using application configuration without modifying legacy HTML helpers.
     */
    public static function formatCurrency(float|int|string $amount, ?string $symbol = null): string
    {
        $resolvedSymbol = $symbol ?? (string) config('app.currency_symbol', 'Rs.');
        $formatted = number_format((float) $amount, 2);

        return str_ends_with($resolvedSymbol, ' ')
            ? $resolvedSymbol . $formatted
            : $resolvedSymbol . ' ' . $formatted;
    }
}

