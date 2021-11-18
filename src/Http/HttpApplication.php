<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http;

use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zorachka\Framework\Http\Emitter\Emitter;

final class HttpApplication implements Application
{
    private RequestHandlerInterface $requestHandler;
    private ServerRequestFactoryInterface $serverRequestFactory;
    private Emitter $emitter;

    /**
     * @param RequestHandlerInterface $requestHandler
     * @param ServerRequestFactoryInterface $serverRequestFactory
     * @param Emitter $emitter
     */
    public function __construct(
        RequestHandlerInterface $requestHandler,
        ServerRequestFactoryInterface $serverRequestFactory,
        Emitter $emitter,
    ) {
        $this->requestHandler = $requestHandler;
        $this->serverRequestFactory = $serverRequestFactory;
        $this->emitter = $emitter;
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $response = $this->requestHandler->handle($this->serverRequestFactory::fromGlobals());
        $this->emitter->emit($response);
    }
}
