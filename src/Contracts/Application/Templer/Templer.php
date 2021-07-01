<?php

declare(strict_types=1);

namespace Zorachka\Contracts\Application\Templer;

interface Templer
{
    /**
     * Get file template extension.
     * @return string
     */
    public function getExtension(): string;

    /**
     * Renders a template.
     * @param string $name The template name
     * @param array $context
     * @return string
     */
    public function render(string $name, array $context = []): string;
}
