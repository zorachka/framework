<?php

declare(strict_types=1);

namespace Zorachka\Application\Support;

final class JsonDecoder
{
    /**
     * Decode json string to array
     * @throws \JsonException
     */
    public static function decode(string $json): array
    {
        return \json_decode($json, true, 512, \JSON_THROW_ON_ERROR);
    }
}
