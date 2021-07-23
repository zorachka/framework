<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Middleware;

use DomainException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Zorachka\Application\Http\ResponseFactory;

final class DomainExceptionHandler implements MiddlewareInterface
{
    private LoggerInterface $logger;
    private ResponseFactory $responseFactory;

    public function __construct(LoggerInterface $logger, ResponseFactory $responseFactory)
    {
        $this->logger = $logger;
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (DomainException $exception) {
            $this->logger->warning($exception->getMessage(), [
                'exception' => $exception,
                'url' => (string)$request->getUri(),
            ]);

            return $this->responseFactory->json([
                'message' => $exception->getMessage(),
            ], 409);
        }
    }
}
