<?php

declare(strict_types=1);

namespace Zorachka\Framework\Directories;

use Psr\Container\ContainerInterface;
use Zorachka\Framework\Container\ServiceProvider;

final class DirectoriesServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            Directories::class => fn(ContainerInterface $container) => new FilesystemDirectories(
                $container->get(DirectoriesConfig::class)
            ),
            DirectoriesConfig::class => fn() => DirectoriesConfig::withDefaults(),
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
