<?php

declare(strict_types=1);

namespace Zorachka\Framework\Directories;

interface Directories
{
    public const ROOT = '@root';
    public const PUBLIC = '@public';

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Get directory.
     * @param string $name
     * @return string
     * @throws DirectoryException When no directory found.
     */
    public function get(string $name): string;
}
