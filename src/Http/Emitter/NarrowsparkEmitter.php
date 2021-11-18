<?php

declare(strict_types=1);

namespace Zorachka\Framework\Http\Emitter;

use Narrowspark\HttpEmitter\SapiEmitter;
use Psr\Http\Message\ResponseInterface;

final class NarrowsparkEmitter implements Emitter
{
    private SapiEmitter $emitter;

    public function __construct(SapiEmitter $emitter)
    {
        $this->emitter = $emitter;
    }

    public function emit(ResponseInterface $response): void
    {
        $this->emitter->emit($response);
    }
}
