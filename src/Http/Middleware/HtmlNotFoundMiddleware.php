<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http\Middleware;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class HtmlNotFoundMiddleware implements NotFoundHandler
{
    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if ($response->getStatusCode() === 404) {
            return new HtmlResponse('Not found', 404);
        }

        return $response;
    }
}
