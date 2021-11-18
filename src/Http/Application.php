<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http;

interface Application
{
    /**
     * Run application.
     */
    public function run(): void;
}
