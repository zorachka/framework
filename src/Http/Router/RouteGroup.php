<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http\Router;

final class RouteGroup
{
    private string $prefix;
    /**
     * @var Route[]
     */
    private array $routes;

    /**
     * @param string $prefix
     * @param Route[] $routes
     */
    private function __construct(string $prefix, array $routes)
    {
        $this->prefix = $prefix;
        $this->routes = $routes;
    }

    public static function with(string $prefix, array $routes): self
    {
        return new self($prefix, $routes);
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
