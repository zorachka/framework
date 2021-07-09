<?php

declare(strict_types=1);

namespace Zorachka\Application\Support;

final class JsonEncoder
{
    /**
     * Encode array to json string
     * @throws \JsonException
     */
    public static function encode(array $array): string
    {
        return \json_encode($array, JSON_THROW_ON_ERROR);
    }
}
