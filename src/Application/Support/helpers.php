<?php

declare(strict_types=1);

namespace Zorachka\Application\Support;

use JsonException;
use RuntimeException;

/**
 * @param string $name
 * @param string|bool|null $default
 * @return bool|string
 * @throws RuntimeException
 */
function env(string $name, $default = null)
{
    $value = getenv($name);

    if ($value !== false) {
        switch (strtolower($value)) {
            case 'true':
                return true;
            case 'false':
                return false;
            default:
                return $value;
        }
    }

    if ($default !== null) {
        return $default;
    }

    throw new RuntimeException('Undefined env variable: ' . $name);
}

/**
 * @throws JsonException
 */
function json_encode($array): string
{
    return \json_encode($array, JSON_THROW_ON_ERROR);
}

/**
 * @throws JsonException
 */
function json_decode(string $json): array
{
    return \json_decode($json, true, JSON_THROW_ON_ERROR);
}
