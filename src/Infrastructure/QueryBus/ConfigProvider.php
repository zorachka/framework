<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\QueryBus;

use Psr\Container\ContainerInterface;
use Zorachka\Application\QueryBus\QueryBus;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::withDefaults();
        $defaults = $defaultConfig();

        return [
            QueryBus::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $bus = $config['query_bus'] ?? [];

                $registry = new QueryBusFetchersRegistry();

                foreach ($bus['fetchers_map'] as $queryClassName => $fetcherClassName) {
                    $registry->setupFetcherForQuery($queryClassName, $container->get($fetcherClassName));
                }

                return new ZorachkaQueryBus($registry);
            },
            'config' => $defaults['config'],
        ];
    }
}
