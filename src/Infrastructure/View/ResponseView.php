<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\View;

use Psr\Http\Message\ResponseInterface;
use Zorachka\Application\Http\ResponseFactory;
use Zorachka\Application\Templer\Templer;
use Zorachka\Application\View\View;

final class ResponseView implements View
{
    private Templer $templer;
    private ResponseFactory $responseFactory;

    public function __construct(Templer $templer, ResponseFactory $responseFactory)
    {
        $this->templer = $templer;
        $this->responseFactory = $responseFactory;
    }

    public function response(string $name, array $context = []): ResponseInterface
    {
        $html = $this->templer->render($name, $context);

        return $this->responseFactory->html($html);
    }
}
