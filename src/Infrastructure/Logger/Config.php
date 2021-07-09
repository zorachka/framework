<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Logger;

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
                'logger' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'name' => Env::get('APP_NAME', ''),
            'debug' => false,
            'file' => null,
            'stderr' => true,
        ];

        return $self;
    }

    public function name(string $name): self
    {
        $new = clone $this;
        $new->config['name'] = $name;

        return $new;
    }

    public function debug(bool $isEnabled): self
    {
        $new = clone $this;
        $new->config['debug'] = $isEnabled;

        return $new;
    }

    public function file(string $file): self
    {
        $new = clone $this;
        $new->config['file'] = $file;

        return $new;
    }

    public function stderr(bool $isEnabled): self
    {
        $new = clone $this;
        $new->config['stderr'] = $isEnabled;

        return $new;
    }
}
