<?php

declare(strict_types=1);

namespace Core\Config;

/**
 * Centralized dot-notation configuration repository backed by config/*.php files.
 */
final class ConfigRepository
{
    /** @var array<string, array<string, mixed>> */
    private array $items = [];

    /**
     * @param array<string, array<string, mixed>> $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Load named configuration files from config directory.
     * Excludes legacy standalone scripts such as config/db.php.
     *
     * @param list<string> $modules
     */
    public static function loadFromPath(string $configDir, array $modules = ['app', 'database', 'session']): self
    {
        $loaded = [];

        foreach ($modules as $module) {
            $file = rtrim($configDir, '/\\') . '/' . $module . '.php';
            if (is_file($file)) {
                $data = require $file;
                if (is_array($data)) {
                    $loaded[$module] = $data;
                }
            }
        }

        return new self($loaded);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        $segments = explode('.', $key);
        $current = $this->items;

        foreach ($segments as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return $default;
            }
            $current = $current[$segment];
        }

        return $current;
    }

    public function has(string $key): bool
    {
        $sentinel = new \stdClass();
        return $this->get($key, $sentinel) !== $sentinel;
    }

    public function set(string $key, mixed $value): void
    {
        $segments = explode('.', $key);
        $target = &$this->items;

        while (count($segments) > 1) {
            $segment = array_shift($segments);
            if (!isset($target[$segment]) || !is_array($target[$segment])) {
                $target[$segment] = [];
            }
            $target = &$target[$segment];
        }

        $last = array_shift($segments);
        if ($last !== null) {
            $target[$last] = $value;
        }
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function all(): array
    {
        return $this->items;
    }
}

