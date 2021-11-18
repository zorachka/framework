<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http\Router;

interface RoutesProvider
{
    /**
     * Return array of Route or RouteGroup.
     * @return array
     */
    public static function getRoutesAndGroups(): array;
}
