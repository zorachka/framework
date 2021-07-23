<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer\Twig\Extensions\Frontend;

use Psr\Container\ContainerInterface;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::withDefaults();
        $defaults = $defaultConfig->build();

        return [
            FrontendUrlGenerator::class => function (ContainerInterface $container): FrontendUrlGenerator {
                $config = $container->get('config')['frontend'];

                return new FrontendUrlGenerator($config['url']);
            },
            'config' => $defaults['config']
        ];
    }
}
