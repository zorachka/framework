<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

use DateTimeZone;
use Webmozart\Assert\Assert;

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
                'clock' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'timezone' => 'UTC',
        ];

        return $self;
    }

    public function timezone(string $timezone): self
    {
        Assert::inArray($timezone, DateTimeZone::listIdentifiers(DateTimeZone::ALL));
        $new = clone $this;
        $new->config['timezone'] = $timezone;

        return $new;
    }
}
