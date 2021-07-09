<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Application
{
    /**
     * @param ServerRequestInterface|null $request
     */
    public function run(?ServerRequestInterface $request = null): void;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface;

    /**
     * @return ContainerInterface
     */
    public function container(): ContainerInterface;
}
