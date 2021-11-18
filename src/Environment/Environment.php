<?php

declare(strict_types=1);

namespace Zorachka\Framework\Environment;

interface Environment
{
    public const PRODUCTION = 'production';
    public const DEVELOPMENT = 'development';
    public const TEST = 'test';

    /**
     * Get environment value.
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get(string $name, $default = null): mixed;
}
