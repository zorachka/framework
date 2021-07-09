<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Mailer;

use Zorachka\Application\Support\Env;

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
                'mailer' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'host' => Env::get('MAILER_HOST'),
            'port' => Env::get('MAILER_PORT'),
            'user' => Env::get('MAILER_USER'),
            'password' => Env::get('MAILER_PASSWORD'),
            'encryption' => Env::get('MAILER_ENCRYPTION'),
            'from_name' => Env::get('MAILER_FROM_NAME'),
            'from_email' => Env::get('MAILER_FROM_EMAIL'),
        ];

        return $self;
    }

    public function host(string $host): self
    {
        $new = clone $this;
        $new->config['host'] = $host;

        return $new;
    }

    public function port(string $host): self
    {
        $new = clone $this;
        $new->config['port'] = $host;

        return $new;
    }

    public function user(string $user): self
    {
        $new = clone $this;
        $new->config['user'] = $user;

        return $new;
    }

    public function password(string $password): self
    {
        $new = clone $this;
        $new->config['password'] = $password;

        return $new;
    }

    public function encryption(string $encryption): self
    {
        $new = clone $this;
        $new->config['encryption'] = $encryption;

        return $new;
    }

    public function fromName(string $fromName): self
    {
        $new = clone $this;
        $new->config['from_name'] = $fromName;

        return $new;
    }

    public function fromEmail(string $fromEmail): self
    {
        $new = clone $this;
        $new->config['from_email'] = $fromEmail;

        return $new;
    }
}
