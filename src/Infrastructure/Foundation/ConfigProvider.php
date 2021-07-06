<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Foundation;

use Laminas\Diactoros\ResponseFactory;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Strategy\StrategyInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $config = Config::defaults();
        $defaults = $config();

        return [
            ResponseFactoryInterface::class => static function () {
                return new ResponseFactory();
            },
            Router::class => static function (ContainerInterface $container) {
                /** @var StrategyInterface $strategy */
                $strategy = (new ApplicationStrategy)->setContainer($container);
                $router = new Router();
                $router->setStrategy($strategy);

                return $router;
            },
            \Zorachka\Contracts\Foundation\Application::class => static function (ContainerInterface $container) {
                return new Application($container);
            },

            'config' => $defaults['config'],
        ];
    }
}
