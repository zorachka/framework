<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\View;

use Psr\Container\ContainerInterface;
use Zorachka\Application\Http\ResponseFactory;
use Zorachka\Application\Templer\Templer;
use Zorachka\Application\View\View;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            View::class => static function (ContainerInterface $container) {
                /** @var ResponseFactory $responseFactory */
                $responseFactory = $container->get(ResponseFactory::class);
                /** @var Templer $templer */
                $templer = $container->get(Templer::class);

                return new ResponseView($templer, $responseFactory);
            }
        ];
    }
}
