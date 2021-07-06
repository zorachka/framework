<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer\Twig;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\FilesystemLoader;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            Environment::class => function (ContainerInterface $container): Environment {
                $config = $container->has('config') ? $container->get('config') : [];
                $twig = $config['twig'] ?? [];

                $loader = new FilesystemLoader();

                $foundation = $config['foundation'] ?? [];
                $rootPath = $foundation['root_path'] ?? null;

                $templer = $config['templer'];
                $templatesDir = $templer['templates_dir'];
                $cacheDir = $templer['cache_dir'];

                $twig['template_dirs'] = [
                    FilesystemLoader::MAIN_NAMESPACE => \realpath($rootPath . '/' . $templatesDir),
                ];

                $twig['cache_dir'] = \realpath($rootPath . '/' . $cacheDir);

                foreach ($twig['template_dirs'] as $alias => $dir) {
                    $loader->addPath($dir, $alias);
                }

                $environment = new Environment($loader, [
                    'cache' => $templer['debug'] ? false : $twig['cache_dir'],
                    'debug' => $templer['debug'],
                    'strict_variables' => $templer['debug'],
                    'auto_reload' => $templer['debug'],
                ]);

                if ($templer['debug']) {
                    $environment->addExtension(new DebugExtension());
                }

                foreach ($twig['extensions'] as $class) {
                    /** @var ExtensionInterface $extension */
                    $extension = $container->get($class);
                    $environment->addExtension($extension);
                }

                return $environment;
            },

            'config' => $defaults['config'],
        ];
    }
}
