<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http\Router;

use InvalidArgumentException;
use Psr\Http\Server\RequestHandlerInterface;

final class Route
{
    private const GET = 'GET';
    private const POST = 'POST';
    private const PUT = 'PUT';
    private const PATCH = 'PATCH';
    private const DELETE = 'DELETE';

    private string $httpMethod;
    private string $route;
    private string $handler;

    /**
     * @param string $httpMethod
     * @param string $route
     * @param class-string<RequestHandlerInterface> $handler
     */
    private function __construct(string $httpMethod, string $route, string $handler)
    {
        $this->httpMethod = $httpMethod;
        $this->route = $route;
        if (!is_a($handler, RequestHandlerInterface::class, true)) {
            throw new InvalidArgumentException(sprintf(
                'Class "%s" was expected to implement "%s"',
                $handler,
                RequestHandlerInterface::class
            ));
        }
        $this->handler = $handler;
    }

    /**
     * @param string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return Route
     */
    public static function get(string $route, string $handler): self
    {
        return new self(self::GET, $route, $handler);
    }

    /**
     * @param string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return Route
     */
    public static function post(string $route, string $handler): self
    {
        return new self(self::POST, $route, $handler);
    }

    /**
     * @param string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return Route
     */
    public static function put(string $route, string $handler): self
    {
        return new self(self::PUT, $route, $handler);
    }

    /**
     * @param string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return Route
     */
    public static function patch(string $route, string $handler): self
    {
        return new self(self::PATCH, $route, $handler);
    }

    /**
     * @param string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return Route
     */
    public static function delete(string $route, string $handler): self
    {
        return new self(self::DELETE, $route, $handler);
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return class-string
     */
    public function getHandler(): string
    {
        return $this->handler;
    }
}
