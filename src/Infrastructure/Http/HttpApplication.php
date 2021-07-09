<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Http;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HttpApplication implements Application
{
    private ContainerInterface $container;
    private Router $router;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        /** @var Router $router */
        $this->router = $this->container->get(Router::class);
        $this->router->middlewares([
            new BodyParamsMiddleware(),
        ]);
    }

    public function run(?ServerRequestInterface $request = null): void
    {
        if ($request === null) {
            $request = ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $_FILES
            );
        }

        $response = $this->router->dispatch($request);

        // send the response to the browser
        (new SapiEmitter)->emit($response);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->router->dispatch($request);
    }

    /**
     * @return ContainerInterface
     */
    public function container(): ContainerInterface
    {
        return $this->container;
    }
}
