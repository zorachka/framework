<?php

declare(strict_types=1);

namespace Zorachka\Application\Support;

trait Mapping
{
    private static function getString(array $data, string $key): string
    {
        if (!isset($data[$key])) {
            return '';
        }

        return (string)$data[$key];
    }

    private static function getInt(array $data, string $key): int
    {
        if (!isset($data[$key])) {
            return 0;
        }

        return (int)$data[$key];
    }

    private static function getNonEmptyStringOrNull(
        array $data,
        string $key
    ): ?string {
        if (!isset($data[$key])) {
            return null;
        }

        if (isset($data[$key]) && $data[$key] === '') {
            return null;
        }

        return (string)$data[$key];
    }
}
