<?php

declare(strict_types=1);

namespace Core\Middleware;

use Core\Contracts\MiddlewareInterface;

/**
 * Central middleware registry mapping aliases and route groups cleanly.
 * Future auth, role, and rate-limit middleware register here without changing the router.
 */
final class MiddlewareRegistry
{
    /** @var array<string, callable(): MiddlewareInterface|class-string<MiddlewareInterface>> */
    private array $aliases = [];

    /** @var array<string, list<string>> */
    private array $groups = [];

    /**
     * @param callable(string): MiddlewareInterface|null $resolver
     */
    public function __construct(private readonly mixed $resolver = null)
    {
    }

    /**
     * @param callable(): MiddlewareInterface|class-string<MiddlewareInterface> $target
     */
    public function alias(string $name, callable|string $target): void
    {
        $this->aliases[$name] = $target;
    }

    /**
     * @param list<string> $middlewareNames
     */
    public function group(string $groupName, array $middlewareNames): void
    {
        $this->groups[$groupName] = $middlewareNames;
    }

    /**
     * Expand aliases and group names into ordered MiddlewareInterface instances.
     *
     * @param list<string|MiddlewareInterface> $entries
     * @return list<MiddlewareInterface>
     */
    public function resolve(array $entries): array
    {
        $resolved = [];

        foreach ($entries as $entry) {
            if ($entry instanceof MiddlewareInterface) {
                $resolved[] = $entry;
                continue;
            }

            if (isset($this->groups[$entry])) {
                foreach ($this->resolve($this->groups[$entry]) as $groupItem) {
                    $resolved[] = $groupItem;
                }
                continue;
            }

            if (isset($this->aliases[$entry])) {
                $target = $this->aliases[$entry];
                if (is_callable($target)) {
                    $resolved[] = $target();
                    continue;
                }
                $entry = $target;
            }

            if (is_string($entry) && $this->resolver !== null && class_exists($entry)) {
                $resolved[] = ($this->resolver)($entry);
                continue;
            }

            if (is_string($entry) && class_exists($entry)) {
                $instance = new $entry();
                if ($instance instanceof MiddlewareInterface) {
                    $resolved[] = $instance;
                    continue;
                }
            }

            throw new \InvalidArgumentException(sprintf('Unknown or invalid middleware "%s".', is_string($entry) ? $entry : get_debug_type($entry)));
        }

        return $resolved;
    }

    public function hasAlias(string $name): bool
    {
        return isset($this->aliases[$name]);
    }

    /**
     * @return list<string>
     */
    public function getGroup(string $groupName): array
    {
        return $this->groups[$groupName] ?? [];
    }
}

