<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Env;

interface EnvLoader
{
    /**
     * Load environment variables.
     */
    public function load(): void;
}
