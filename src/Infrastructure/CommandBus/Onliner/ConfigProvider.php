<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner;

use Onliner\CommandBus\Builder;
use Onliner\CommandBus\Dispatcher;
use Onliner\CommandBus\Remote\RemoteExtension;
use Onliner\CommandBus\Remote\Serializer;
use Onliner\CommandBus\Remote\Transport;
use Onliner\CommandBus\Retry\RetryExtension;
use Psr\Container\ContainerInterface;
use Zorachka\Application\CommandBus\CommandBus;
use Zorachka\Infrastructure\CommandBus\Onliner\Console\ConsumeCommand;
use Zorachka\Infrastructure\CommandBus\Onliner\Factory\SerializerFactory;
use Zorachka\Infrastructure\CommandBus\Onliner\Factory\TransportFactory;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            Serializer::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $serializer = $config['command_bus']['remote']['serializer'];
                $type = $serializer['type'] ?? SerializerFactory::DEFAULT;

                return SerializerFactory::create($type, $serializer['options'] ?? []);
            },
            Transport::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $transport = $config['command_bus']['remote']['transport'];

                return TransportFactory::create($transport['dsn'], $transport['options']);
            },
            RemoteExtension::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $remote = $config['command_bus']['remote'];

                $extension = new RemoteExtension($container->get(Transport::class), $container->get(Serializer::class));
                $extension->local(...($remote['local'] ?? []));

                return $extension;
            },
            RetryExtension::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $retries = $config['command_bus']['retries'];

                $default = isset($retries['default']) ? $container->get($retries['default']) : null;
                $extension = new RetryExtension($default);

                foreach ($retries['policies'] ?? [] as $command => $policy) {
                    $extension->policy($command, $container->get($policy));
                }

                return $extension;
            },
            Dispatcher::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $bus = $config['command_bus'];

                $handlersMap = empty($bus['handlers_map']) ? [] : $bus['handlers_map'];

                $builder = new Builder();
                foreach ($handlersMap as $commandClassName => $handlerClassName) {
                    $builder
                        ->handle($commandClassName, $container->get($handlerClassName));
                }

                $middlewares = empty($bus['middlewares']) ? [] : $bus['middlewares'];
                foreach ($middlewares as $middleware) {
                    $builder->middleware($container->get($middleware));
                }

                $extensions = empty($bus['extensions']) ? [] : $bus['extensions'];
                foreach ($extensions as $extension) {
                    $builder->use($container->get($extension));
                }

                return $builder->build();
            },
            ConsumeCommand::class => static function (ContainerInterface $container) {
                return new ConsumeCommand(
                    $container->get(Transport::class),
                    $container->get(Dispatcher::class),
                    $container->get('config')['command_bus']['remote']['consumer']
                );
            },
            CommandBus::class => static function (ContainerInterface $container) {
                $dispatcher = $container->get(Dispatcher::class);

                return new OnlinerCommandBus($dispatcher);
            },
            'config' => $defaults['config'],
        ];
    }
}
