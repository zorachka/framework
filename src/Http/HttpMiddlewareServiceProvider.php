<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http;

use Zorachka\Framework\Container\ServiceProvider;
use Zorachka\Framework\Http\Middleware\HtmlNotFoundMiddleware;
use Zorachka\Framework\Http\Middleware\NotFoundHandler;

final class HttpMiddlewareServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            NotFoundHandler::class => fn() => new HtmlNotFoundMiddleware,
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getExtensions(): array
    {
        return [];
    }
}
