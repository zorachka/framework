<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner\Console;

use Exception;
use Onliner\CommandBus\Dispatcher;
use Onliner\CommandBus\Remote\AMQP\Queue;
use Onliner\CommandBus\Remote\Consumer;
use Onliner\CommandBus\Remote\Transport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsumeCommand extends Command
{
    private Transport $transport;
    private Dispatcher $dispatcher;
    private ?Consumer $consumer = null;
    private array $config;

    /**
     * ConsumeCommand constructor.
     * @param Transport $transport
     * @param Dispatcher $dispatcher
     * @param array $config
     */
    public function __construct(Transport $transport, Dispatcher $dispatcher, array $config)
    {
        parent::__construct();
        $this->transport = $transport;
        $this->dispatcher = $dispatcher;
        $this->config = $config;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName("queue:consume")
            ->setDescription('Consume messages')
            ->addArgument(
                'pattern',
                InputArgument::REQUIRED,
                'Routing pattern to subscribe'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->subscribeSignals();

            $pattern = $input->getArgument('pattern');

            $options = $this->config['queues'][$pattern] ?? [
                    'durable' => true,
                ];

            $options['pattern'] = $pattern;

            $this->consumer = $this->transport->consume();
            $this->consumer->consume(Queue::create($options));
            $this->consumer->run($this->dispatcher, $this->config['options'] ?? []);

            $output->writeln('<info>Consumer was started.</info>');

            return 0;
        } catch (Exception $exception) {
            $output->writeln('<error>Something went wrong: ' . $exception->getMessage() . '</error>');

            return 1;
        }
    }


    /**
     * @return void
     */
    private function subscribeSignals(): void
    {
        pcntl_async_signals();

        foreach ([SIGINT, SIGTERM] as $signal) {
            pcntl_signal($signal, function () {
                if (!$this->consumer) {
                    return;
                }

                $this->consumer->stop();
            });
        }
    }
}
