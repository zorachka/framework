<?php

declare(strict_types=1);

namespace Zorachka\Framework\Clock;

use DateTimeZone;
use Webmozart\Assert\Assert;

final class ClockConfig
{
    private string $timezone;

    /**
     * @param string $timezone
     */
    private function __construct(string $timezone)
    {
        Assert::inArray($timezone, DateTimeZone::listIdentifiers(DateTimeZone::ALL));
        $this->timezone = $timezone;
    }

    /**
     * @param string $timezone
     * @return static
     */
    public static function withDefaults(
        string $timezone = 'UTC',
    ): self
    {
        return new self($timezone);
    }

    /**
     * @param string $timezone
     * @return $this
     */
    public function withTimezone(string $timezone): self
    {
        Assert::inArray($timezone, DateTimeZone::listIdentifiers(DateTimeZone::ALL));
        $new = clone $this;
        $new->timezone = $timezone;

        return $new;
    }

    /**
     * @return string
     */
    public function timezone(): string
    {
        return $this->timezone;
    }
}
