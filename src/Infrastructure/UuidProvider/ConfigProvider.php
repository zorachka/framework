<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\UuidProvider;

use Zorachka\Contracts\Application\UuidProvider\UuidProvider;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            UuidProvider::class => static function () {
                return new RamseyUuidProvider();
            }
        ];
    }
}
