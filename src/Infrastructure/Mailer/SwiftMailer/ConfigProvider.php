<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Mailer\SwiftMailer;

use Finesse\SwiftMailerDefaultsPlugin\SwiftMailerDefaultsPlugin;
use Psr\Container\ContainerInterface;
use Swift_Mailer;
use Swift_SmtpTransport;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            Swift_Mailer::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $mailer = $config['mailer'];

                $transport = (new Swift_SmtpTransport($mailer['host'], $mailer['port']))
                    ->setUsername($mailer['user'])
                    ->setPassword($mailer['password'])
                    ->setEncryption($mailer['encryption']);

                $swiftMailer = new Swift_Mailer($transport);

                $swiftMailer->registerPlugin(new SwiftMailerDefaultsPlugin([
                    'from' => [
                        $mailer['from_email'] => $mailer['from_name'],
                    ],
                ]));

                return $swiftMailer;
            },
        ];
    }
}
