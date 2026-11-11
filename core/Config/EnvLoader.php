<?php

declare(strict_types=1);

namespace Core\Config;

/**
 * Lightweight, zero-dependency .env parser and environment accessor.
 */
final class EnvLoader
{
    private static bool $loaded = false;

    /**
     * Load environment variables from a .env file.
     */
    public static function load(string $filePath, bool $overwrite = false): bool
    {
        if (!is_file($filePath) || !is_readable($filePath)) {
            return false;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return false;
        }

        foreach ($lines as $rawLine) {
            $line = trim($rawLine);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (str_starts_with($line, 'export ')) {
                $line = ltrim(substr($line, 7));
            }

            $eqPos = strpos($line, '=');
            if ($eqPos === false) {
                continue;
            }

            $key = trim(substr($line, 0, $eqPos));
            if ($key === '' || !preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $key)) {
                continue;
            }

            $rawValue = trim(substr($line, $eqPos + 1));
            $value = self::parseValue($rawValue);

            if (!$overwrite && (array_key_exists($key, $_ENV) || array_key_exists($key, $_SERVER) || getenv($key) !== false)) {
                continue;
            }

            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }

        self::$loaded = true;
        return true;
    }

    /**
     * Retrieve a typed environment value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $_ENV)) {
            $value = $_ENV[$key];
        } elseif (array_key_exists($key, $_SERVER)) {
            $value = $_SERVER[$key];
        } else {
            $envVal = getenv($key);
            if ($envVal === false) {
                return $default;
            }
            $value = $envVal;
        }

        if (!is_string($value)) {
            return $value;
        }

        return match (strtolower($value)) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'empty', '(empty)' => '',
            'null', '(null)' => null,
            default => $value,
        };
    }

    public static function isLoaded(): bool
    {
        return self::$loaded;
    }

    public static function reset(): void
    {
        self::$loaded = false;
    }

    private static function parseValue(string $raw): string
    {
        if ($raw === '') {
            return '';
        }

        $firstChar = $raw[0];
        if ($firstChar === '"' || $firstChar === "'") {
            return self::parseQuotedValue($raw, $firstChar);
        }

        // Strip unquoted inline comments preceded by whitespace
        $commentPos = preg_match('/\s+#/', $raw, $matches, PREG_OFFSET_CAPTURE);
        if ($commentPos === 1) {
            $raw = substr($raw, 0, $matches[0][1]);
        }

        return trim($raw);
    }

    private static function parseQuotedValue(string $raw, string $quote): string
    {
        $len = strlen($raw);
        $result = '';
        $escaped = false;

        for ($i = 1; $i < $len; $i++) {
            $ch = $raw[$i];

            if ($quote === '"' && $escaped) {
                $result .= match ($ch) {
                    'n' => "\n",
                    'r' => "\r",
                    't' => "\t",
                    '\\' => '\\',
                    '"' => '"',
                    default => $ch,
                };
                $escaped = false;
                continue;
            }

            if ($quote === '"' && $ch === '\\') {
                $escaped = true;
                continue;
            }

            if ($ch === $quote) {
                break;
            }

            $result .= $ch;
        }

        return $result;
    }
}

