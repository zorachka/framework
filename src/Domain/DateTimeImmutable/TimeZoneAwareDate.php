<?php

declare(strict_types=1);

namespace Zorachka\Domain\DateTimeImmutable;

use DateTimeImmutable;
use DateTimeZone;
use Webmozart\Assert\Assert;

final class TimeZoneAwareDate
{
    private const FORMAT = 'Y-m-d';
    private const TIMEZONE = 'UTC';

    /**
     * @param string $date
     * @return DateTimeImmutable
     */
    public static function createDateTimeImmutable(string $date): DateTimeImmutable
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
    public static function formatToString(DateTimeImmutable $date): string
    {
        return $date->format(self::FORMAT);
    }
}
