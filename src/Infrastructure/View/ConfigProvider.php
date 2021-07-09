<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\View;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Zorachka\Application\Templer\Templer;
use Zorachka\Application\View\View;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            View::class => static function (ContainerInterface $container) {
                /** @var ResponseFactoryInterface $responseFactory */
                $responseFactory = $container->get(ResponseFactoryInterface::class);
                /** @var Templer $templer */
                $templer = $container->get(Templer::class);

                return new ResponseView($templer, $responseFactory);
            }
        ];
    }
}
