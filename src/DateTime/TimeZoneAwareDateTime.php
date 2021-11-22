<?php

declare(strict_types=1);

namespace Zorachka\Framework\DateTime;

use DateTimeZone;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

final class TimeZoneAwareDateTime
{
    private const FORMAT = 'Y-m-d H:i:s';
    private const TIMEZONE = 'UTC';

    /**
     * @param string $date
     * @return DateTimeImmutable
     */
    public static function fromString(string $date): DateTimeImmutable
    {
        Assert::notEmpty($date);

        $dateTimeImmutable = DateTimeImmutable::createFromFormat(
            self::FORMAT,
            $date,
            new DateTimeZone(self::TIMEZONE)
        );
        Assert::isInstanceOf($dateTimeImmutable, DateTimeImmutable::class);

        return $dateTimeImmutable;
    }

    /**
     * @param DateTimeImmutable $date
     * @return string
     */
    public static function asString(DateTimeImmutable $date): string
    {
        return $date->format(self::FORMAT);
    }
}
