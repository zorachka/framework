<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http\Emitter;

use Psr\Http\Message\ResponseInterface;

interface Emitter
{
    public function emit(ResponseInterface $response): void;
}
