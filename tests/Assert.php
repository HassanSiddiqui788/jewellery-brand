<?php

declare(strict_types=1);

namespace Tests;

final class AssertionFailed extends \RuntimeException
{
}

final class SkippedTest extends \RuntimeException
{
}

final class Assert
{
    public static function true(bool $condition, string $message = 'Expected true, got false.'): void
    {
        if (!$condition) {
            throw new AssertionFailed($message);
        }
    }

    public static function false(bool $condition, string $message = 'Expected false, got true.'): void
    {
        if ($condition) {
            throw new AssertionFailed($message);
        }
    }

    public static function same(mixed $expected, mixed $actual, string $message = ''): void
    {
        if ($expected !== $actual) {
            $detail = sprintf(
                'Expected %s, got %s.',
                var_export($expected, true),
                var_export($actual, true)
            );
            throw new AssertionFailed($message !== '' ? $message . ' ' . $detail : $detail);
        }
    }

    public static function contains(string $needle, string $haystack, string $message = ''): void
    {
        if (!str_contains($haystack, $needle)) {
            $detail = sprintf('Expected string containing "%s".', $needle);
            throw new AssertionFailed($message !== '' ? $message . ' ' . $detail : $detail);
        }
    }

    public static function notContains(string $needle, string $haystack, string $message = ''): void
    {
        if (str_contains($haystack, $needle)) {
            $detail = sprintf('Did not expect string to contain "%s".', $needle);
            throw new AssertionFailed($message !== '' ? $message . ' ' . $detail : $detail);
        }
    }

    /**
     * @param class-string<\Throwable> $exceptionClass
     */
    public static function throws(string $exceptionClass, callable $callback, string $message = ''): \Throwable
    {
        try {
            $callback();
        } catch (\Throwable $e) {
            if ($e instanceof $exceptionClass) {
                return $e;
            }
            throw new AssertionFailed(sprintf(
                'Expected exception %s, got %s (%s).',
                $exceptionClass,
                $e::class,
                $e->getMessage()
            ));
        }

        throw new AssertionFailed($message !== '' ? $message : sprintf('Expected exception %s was not thrown.', $exceptionClass));
    }

    public static function skip(string $reason): never
    {
        throw new SkippedTest($reason);
    }
}

