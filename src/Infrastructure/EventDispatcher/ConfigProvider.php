<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\EventDispatcher;

use League\Event\PrioritizedListenerRegistry;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use League\Event\EventDispatcher;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            EventDispatcher::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $events = empty($config['events']) ? [] : $config['events'];

                $listenerRegistry = new PrioritizedListenerRegistry();

                foreach ($events as $eventIdentifier => $listeners) {
                    foreach ($listeners as $eventListener) {
                        list($listener, $priority) = $eventListener;

                        // Subscribe with the listener registry
                        $listenerRegistry->subscribeTo($eventIdentifier, $container->get($listener), $priority);
                    }
                }

                return new EventDispatcher($listenerRegistry);
            },
            EventDispatcherInterface::class => static function (ContainerInterface $container) {
                /** @var EventDispatcher $dispatcher */
                $dispatcher = $container->get(EventDispatcher::class);

                return new LeagueEventDispatcher($dispatcher);
            },
            'config' => $defaults['config'],
        ];
    }
}
