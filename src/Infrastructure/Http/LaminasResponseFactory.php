<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Http;

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Zorachka\Application\Http\ResponseFactory;

final class LaminasResponseFactory implements ResponseFactory
{
    /**
     * @inheritDoc
     */
    public function redirect($uri, int $status = 302, array $headers = []): ResponseInterface
    {
        return new RedirectResponse($uri, $status, $headers);
    }

    /**
     * @inheritDoc
     */
    public function json(
        $data,
        int $status = 200,
        array $headers = [],
        int $encodingOptions = self::DEFAULT_JSON_FLAGS
    ): ResponseInterface {
        return new JsonResponse($data, $status, $headers, $encodingOptions);
    }

    /**
     * @inheritDoc
     */
    public function empty(int $status = 204, array $headers = []): ResponseInterface
    {
        return new EmptyResponse($status, $headers);
    }

    /**
     * @inheritDoc
     */
    public function html($html, int $status = 200, array $headers = []): ResponseInterface
    {
        return new HtmlResponse($html, $status, $headers);
    }
}
