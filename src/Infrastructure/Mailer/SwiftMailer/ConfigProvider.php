<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Mailer\SwiftMailer;

use Finesse\SwiftMailerDefaultsPlugin\SwiftMailerDefaultsPlugin;
use Psr\Container\ContainerInterface;
use Swift_Mailer;
use Swift_SmtpTransport;

use function Zorachka\Foundation\env;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            Swift_Mailer::class => static function (ContainerInterface $container) {
                $config = $container->get('config')['mailer'];

                $transport = (new Swift_SmtpTransport($config['host'], $config['port']))
                    ->setUsername($config['user'])
                    ->setPassword($config['password'])
                    ->setEncryption($config['encryption']);

                $mailer = new Swift_Mailer($transport);

                $mailer->registerPlugin(new SwiftMailerDefaultsPlugin([
                    'from' => $config['from'],
                ]));

                return $mailer;
            },

            'config' => [
                'mailer' => [
                    'host' => env('MAILER_HOST'),
                    'port' => env('MAILER_PORT'),
                    'user' => env('MAILER_USER'),
                    'password' => env('MAILER_PASSWORD'),
                    'encryption' => env('MAILER_ENCRYPTION'),
                    'from' => [
                        env('MAILER_FROM_EMAIL') => env('MAILER_FROM_NAME')
                    ]
                ]
            ],
        ];
    }
}
