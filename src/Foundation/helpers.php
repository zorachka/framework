<?php

declare(strict_types=1);

namespace Zorachka\Foundation;

use RuntimeException;

/**
 * @param string $name
 * @param string|bool|null $default
 * @return bool|string
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
