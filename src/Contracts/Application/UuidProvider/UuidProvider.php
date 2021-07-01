<?php

declare(strict_types=1);

namespace Zorachka\Contracts\Application\UuidProvider;

interface UuidProvider
{
    /**
     * Return UUID string.
     * @return string
     */
    public static function next(): string;
}
