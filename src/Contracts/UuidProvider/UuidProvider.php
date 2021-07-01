<?php

declare(strict_types=1);

namespace Zorachka\Contracts\UuidProvider;

interface UuidProvider
{
    /**
     * Return UUID string.
     * @return string
     */
    public static function next(): string;
}
