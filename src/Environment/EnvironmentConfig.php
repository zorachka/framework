<?php

declare(strict_types=1);

namespace Zorachka\Framework\Environment;

final class EnvironmentConfig
{
    private array $required;

    private function __construct(array $required)
    {
        $this->required = $required;
    }

    public static function withDefaults(array $required = [])
    {
        return new self($required);
    }

    public function withRequired(array $required)
    {
        $new = clone $this;
        $new->required = $required;

        return $new;
    }

    public function required(): array
    {
        return $this->required;
    }
}
