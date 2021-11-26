<?php

declare(strict_types=1);

namespace Zorachka\Framework\UuidProvider;

interface UuidProvider
{
    /**
     * Return UUID string.
     * @return string
     */
    public static function next(): string;
}
