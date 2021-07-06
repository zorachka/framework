<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Env;

use Dotenv\Dotenv;

final class DotEnvLoader implements EnvLoader
{
    private Dotenv $dotenv;

    public function __construct(Dotenv $dotenv)
    {
        $this->dotenv = $dotenv;
    }

    /**
     * @inheritDoc
     */
    public function load(): void
    {
        $this->dotenv->load();
    }
}
