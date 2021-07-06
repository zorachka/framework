<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Mailer;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            'config' => $defaults['config'],
        ];
    }
}
