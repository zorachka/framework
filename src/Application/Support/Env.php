<?php

declare(strict_types=1);

namespace Zorachka\Application\Support;

use RuntimeException;

final class Env
{
    /**
     * Get env variable or default value
     * @param string $name
     * @param null $default
     * @return mixed
     */
    public static function get(string $name, $default = null)
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
}
