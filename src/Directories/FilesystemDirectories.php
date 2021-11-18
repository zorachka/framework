<?php

declare(strict_types=1);

namespace Zorachka\Framework\Directories;

final class FilesystemDirectories implements Directories
{
    private DirectoriesConfig $config;

    public function __construct(DirectoriesConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->config->directories());
    }

    /**
     * @inheritDoc
     */
    public function get(string $name): string
    {
        if (!$this->has($name)) {
            throw new DirectoryException("Undefined directory '{$name}'");
        }

        return $this->config->directories()[$name];
    }
}
