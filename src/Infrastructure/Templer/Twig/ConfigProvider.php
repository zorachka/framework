<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer\Twig;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\FilesystemLoader;
use Zorachka\Infrastructure\Templer\Twig\Extensions\Frontend\FrontendUrlGenerator;
use Zorachka\Infrastructure\Templer\Twig\Extensions\Frontend\FrontendUrlTwigExtension;
use function Zorachka\Foundation\env;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            Environment::class => function (ContainerInterface $container): Environment {
                /**
                 * @psalm-suppress MixedArrayAccess
                 * @psalm-var array{
                 *     debug:bool,
                 *     template_dirs:array<string,string>,
                 *     cache_dir:string,
                 *     extensions:string[],
                 * } $config
                 */
                $config = $container->get('config')['twig'];

                $loader = new FilesystemLoader();

                foreach ($config['template_dirs'] as $alias => $dir) {
                    $loader->addPath($dir, $alias);
                }

                $environment = new Environment($loader, [
                    'cache' => $config['debug'] ? false : $config['cache_dir'],
                    'debug' => $config['debug'],
                    'strict_variables' => $config['debug'],
                    'auto_reload' => $config['debug'],
                ]);

                if ($config['debug']) {
                    $environment->addExtension(new DebugExtension());
                }

                foreach ($config['extensions'] as $class) {
                    /** @var ExtensionInterface $extension */
                    $extension = $container->get($class);
                    $environment->addExtension($extension);
                }

                return $environment;
            },

            FrontendUrlGenerator::class => function (ContainerInterface $container): FrontendUrlGenerator {
                $config = $container->get('config')['frontend'];

                return new FrontendUrlGenerator($config['url']);
            },

            'config' => [
                'frontend' => [
                    'url' => env('FRONTEND_URL'),
                ],
                'twig' => [
                    'debug' => env('APP_DEBUG'),
                    'template_dirs' => [
                        FilesystemLoader::MAIN_NAMESPACE => __DIR__ . '/../../templates',
                    ],
                    'cache_dir' => __DIR__ . '/../../var/cache/twig',
                    'extensions' => [
                        FrontendUrlTwigExtension::class,
                    ],
                ],
            ],
        ];
    }
}
