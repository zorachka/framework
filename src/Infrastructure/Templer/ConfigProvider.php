<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Zorachka\Application\Templer\Templer;
use Zorachka\Infrastructure\Templer\Twig\TwigTempler;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::withDefaults();
        $defaults = $defaultConfig->build();

        return [
            Templer::class => static function (ContainerInterface $container) {
                $environment = $container->get(Environment::class);

                return new TwigTempler($environment);
            },

            'config' => $defaults['config'],
        ];
    }
}
