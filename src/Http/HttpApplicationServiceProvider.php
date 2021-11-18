<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

use FastRoute\RouteCollector;
use Zorachka\Framework\Http\Middleware\MiddlewaresProvider;
use Zorachka\Framework\Http\Router\Route;
use Zorachka\Framework\Http\Router\RouteGroup;
use Zorachka\Framework\Http\Router\RoutesProvider;
use function FastRoute\simpleDispatcher;

use Middlewares\FastRoute;
use Middlewares\RequestHandler;

use Zorachka\Framework\Http\Emitter\Emitter;
use Zorachka\Framework\Container\ServiceProvider;

use Relay\Relay;

final class HttpApplicationServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            Application::class => static function(ContainerInterface $container) {
                $routes = simpleDispatcher(function (RouteCollector $collector) use ($container) {
                    /** @var RoutesProvider $routesProvider */
                    $routesProvider = $container->get(RoutesProvider::class);
                    $routes = $routesProvider->getRoutesAndGroups();

                    foreach ($routes as $route) {
                        if ($route instanceof Route) {
                            $collector->addRoute(
                                $route->getHttpMethod(),
                                $route->getRoute(),
                                $route->getHandler(),
                            );
                        } else if ($route instanceof RouteGroup) {
                            $prefix = $route->getPrefix();
                            $routes = $route->getRoutes();

                            $collector->addGroup(
                                $prefix,
                                function (RouteCollector $collector) use ($routes) {
                                    foreach ($routes as $route) {
                                        $collector->addRoute(
                                            $route->getHttpMethod(),
                                            $route->getRoute(),
                                            $route->getHandler(),
                                        );
                                    }
                                }
                            );
                        }
                    }
                });

                /** @var MiddlewaresProvider $middlewaresProvider */
                $middlewaresProvider = $container->get(MiddlewaresProvider::class);

                $middlewareQueue = [];

                $baseMiddlewareQueue = [
                    new FastRoute($routes),
                    new RequestHandler($container),
                ];

                foreach ($middlewaresProvider->getMiddlewares() as $middlewareClassName) {
                    $middleware = $container->get($middlewareClassName);
                    $middlewareQueue[] = $middleware;
                }

                foreach ($baseMiddlewareQueue as $middleware) {
                    $middlewareQueue[] = $middleware;
                }

                $requestHandler = new Relay($middlewareQueue);
                $serverRequestFactory = $container->get(ServerRequestFactoryInterface::class);
                $emitter = $container->get(Emitter::class);

                return new HttpApplication(
                    $requestHandler,
                    $serverRequestFactory,
                    $emitter,
                );
            },
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
