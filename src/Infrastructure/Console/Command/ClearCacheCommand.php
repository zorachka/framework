<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Console\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ClearCacheCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName("cache:clear")
            ->setDescription('Clear cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $folders = [
                \dirname(__DIR__) . '/var/cache/config',
                \dirname(__DIR__) . '/var/cache/container',
                \dirname(__DIR__) . '/var/cache/twig',
            ];

            \var_dump($folders);

            $output->writeln('<info>Cache was successfully cleared.</info>');

            return 0;
        } catch (Exception $exception) {
            $output->writeln('<error>Something went wrong: ' . $exception->getMessage() . '</error>');

            return 1;
        }
    }
}
