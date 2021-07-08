<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Tactician;

use Bernard\Command\ConsumeCommand;
use Bernard\Driver\FlatFileDriver;
use Bernard\Producer;
use Bernard\QueueFactory;
use Bernard\QueueFactory\PersistentFactory;
use Bernard\Router\SimpleRouter;
use Bernard\Serializer;
use League\Tactician\Bernard\QueueMiddleware;
use League\Tactician\Bernard\Receiver\SameBusReceiver;
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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zorachka\Contracts\Application\CommandBus\CommandBus;
use Zorachka\Infrastructure\CommandBus\Config;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            CommandBus::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $handlers = empty($config['command_bus']['handlers']) ? [] : $config['command_bus']['handlers'];

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

                /** @var QueueFactory $factory */
                $factory = $container->get(QueueFactory::class);
                $producer = new Producer($factory, $container->get(EventDispatcherInterface::class));

                $queueMiddleware = new QueueMiddleware($producer);

                $tacticianCommandBus = new TacticianCommandBus([
                    new LoggingMiddleware($container->get(LoggerInterface::class)),
                    $queueMiddleware,
                    new LockingMiddleware(),
                    new TransactionMiddleware($container->get(Connection::class)),
                    $commandHandlerMiddleware,
                ]);

                return new LeagueCommandBus($tacticianCommandBus);
            },
            QueueFactory::class => static function (ContainerInterface $container) {
                $rootPath = $container->get('config')['foundation']['root_path'];
                $driver = new FlatFileDriver($rootPath . '/var/messages');

                return new PersistentFactory($driver, new Serializer());
            },
            ConsumeCommand::class => static function (ContainerInterface $container) {
                $commandBus = $container->get(CommandBus::class);
                // Wire the command bus into Bernard's routing system
                $receiver = new SameBusReceiver($commandBus);
                $router = new SimpleRouter();
                $router->add('League\Tactician\Bernard\QueueableCommand', $receiver);

                // Finally, create the Bernard consumer that runs through the pending queue
                $consumer = new Consumer($router, new EventDispatcher());
                /** @var QueueFactory $queueFactory */
                $queueFactory = $container->get(QueueFactory::class);

                return new ConsumeCommand($consumer, $queueFactory);
            },

            'config' => $defaults['config'],
        ];
    }
}
