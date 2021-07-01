<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\View;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Zorachka\Contracts\Application\Templer\Templer;
use Zorachka\Contracts\Application\View\View;

final class ResponseView implements View
{
    private Templer $templer;
    private ResponseFactoryInterface $responseFactory;

    public function __construct(Templer $templer, ResponseFactoryInterface $responseFactory)
    {
        $this->templer = $templer;
        $this->responseFactory = $responseFactory;
    }

    public function response(string $name, array $context = []): ResponseInterface
    {
        $html = $this->templer->render($name, $context);

        $response = $this->responseFactory->createResponse();
        $response->getBody()->write($html);

        return $response;
    }
}
