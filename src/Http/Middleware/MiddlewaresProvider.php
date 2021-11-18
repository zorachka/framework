<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http\Middleware;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewaresProvider
{
    /**
     * Return array of MiddlewareInterface.
     * @return MiddlewareInterface[]
     */
    public static function getMiddlewares(): array;
}
