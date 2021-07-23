<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Tactician;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Connection;
use League\Tactician\Doctrine\DBAL\TransactionMiddleware;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Plugins\LockingMiddleware;
use League\Tactician\CommandBus as TacticianCommandBus;
use Zorachka\Application\CommandBus\CommandBus;
use Zorachka\Infrastructure\CommandBus\Tactician\Middleware\LoggingMiddleware;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::withDefaults();
        $defaults = $defaultConfig();

        return [
            CommandBus::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $handlers = empty($config['command_bus']['handlers_map']) ? [] : $config['command_bus']['handlers_map'];

                // Choose our method name
                $inflector = new HandleInflector();

                // Choose our locator and register our command
                $locator = new InMemoryLocator();
                foreach ($handlers as $commandClassName => $handlerClassName) {
                    $locator->addHandler($container->get($handlerClassName), $commandClassName);
                }

                // Choose our Handler naming strategy
                $nameExtractor = new ClassNameExtractor();

                // Create the middleware that executes commands with Handlers
                $commandHandlerMiddleware = new CommandHandlerMiddleware($nameExtractor, $locator, $inflector);

                $tacticianCommandBus = new TacticianCommandBus([
                    new LoggingMiddleware($container->get(LoggerInterface::class)),
                    new LockingMiddleware(),
                    new TransactionMiddleware($container->get(Connection::class)),
                    $commandHandlerMiddleware,
                ]);

                return new LeagueCommandBus($tacticianCommandBus);
            },

            'config' => $defaults['config'],
        ];
    }
}
