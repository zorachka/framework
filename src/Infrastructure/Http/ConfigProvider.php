<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Http;

use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Strategy\StrategyInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Zorachka\Application\Http\ResponseFactory;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $config = Config::withDefaults();
        $defaults = $config();

        return [
            Router::class => static function (ContainerInterface $container) {
                /** @var StrategyInterface $strategy */
                $strategy = (new ApplicationStrategy())->setContainer($container);
                $router = new Router();
                $router->setStrategy($strategy);

                return $router;
            },
            ResponseFactoryInterface::class => static function () {
                return new \Laminas\Diactoros\ResponseFactory();
            },
            ResponseFactory::class => static function () {
                return new LaminasResponseFactory();
            },
            Application::class => static function (ContainerInterface $container) {
                return new HttpApplication($container);
            },
            'config' => $defaults['config'],
        ];
    }
}
