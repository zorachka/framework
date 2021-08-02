<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\QueryBus\Test;

final class AnotherFetcher
{
    private bool $wasCalled = false;

    public function __invoke(): bool
    {
        $this->wasCalled = true;

        return $this->wasCalled;
    }
}
