<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner;

use Onliner\CommandBus\Middleware\LoggerMiddleware;
use Onliner\CommandBus\Remote\AMQP\AMQPConsumer;
use Onliner\CommandBus\Remote\AMQP\Queue;
use Onliner\CommandBus\Remote\RemoteExtension;
use Onliner\CommandBus\Retry\Policy\ThrowPolicy;
use ReflectionClass;
use Zorachka\Application\CommandBus\AsyncCommand;
use Zorachka\Infrastructure\CommandBus\Onliner\Console\ConsumeCommand;

final class Config
{
    private array $config;

    private function __construct()
    {
    }

    public function __invoke(): array
    {
        return [
            'config' => [
                'command_bus' => $this->config,
                'console' => [
                    'commands' => [
                        ConsumeCommand::class,
                    ]
                ],
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config =  [
            'remote' => [
                'enabled' => true,
                'serializer' => [
                    'type' => 'native',
                    'options' => [
                        // 'key' => 'value',
                    ],
                ],
                'transport' => [
                    'dsn' => 'amqp://guest:guest@localhost:5672',
                    'options' => [
                        // 'key' => 'value',
                        'exchange' => 'common',
                    ],
                ],
                'consumer' => [
                    'options' => [
                         AMQPConsumer::OPTION_ATTEMPTS => 10,
                         AMQPConsumer::OPTION_INTERVAL => 1000,
                    ],
                    'queues' => [
                         'pattern' => [
                             'durable' => true,
                             'args' => [
                                 Queue::MAX_PRIORITY => 3,
                             ],
                         ],
                    ],
                ],
                'local' => [
                    // Command::class,
                ],
            ],
            'retries' => [
                'default' => ThrowPolicy::class,
                'policies' => [
                    // Command::class => CustomPolicy::class,
                ],
            ],
            'handlers_map' => [
                // Command::class => Handler::class,
            ],
            'extensions' => [
                // CustomExtension::class,
                RemoteExtension::class,
            ],
            'middlewares' => [
                LoggerMiddleware::class,
            ],
        ];

        return $self;
    }

    /**
     * @throws \ReflectionException
     */
    public function addHandler(string $commandClassName, string $handlerClassName): self
    {
        $new = clone $this;
        $new->config['handlers_map'][$commandClassName] = $handlerClassName;

        $reflection = new ReflectionClass($commandClassName);
        $isAsyncCommand = $reflection->implementsInterface(AsyncCommand::class);

        if (!$isAsyncCommand) {
            $new->config['remote']['local'][] = $commandClassName;
        }

        return $new;
    }

    public function addExtension(string $extensionClassName): self
    {
        $new = clone $this;
        $new->config['extensions'][] = $extensionClassName;

        return $new;
    }

    public function transport(string $dsn, array $options): self
    {
        $new = clone $this;
        $new->config['remote']['transport']['dsn'] = $dsn;
        $new->config['remote']['transport']['options'] = $options;

        return $new;
    }

    public function addRetryPolicy(string $commandClassName, string $policyClassName): self
    {
        $new = clone $this;
        $new->config['retries']['policies'][$commandClassName] = $policyClassName;

        return $new;
    }

    public function defaultPolicy(string $policyClassName): self
    {
        $new = clone $this;
        $new->config['retries']['default'] = $policyClassName;

        return $new;
    }

    public function addMiddleware(string $middlewareClassName): self
    {
        $new = clone $this;
        $new->config['middlewares'][] = $middlewareClassName;

        return $new;
    }
}
