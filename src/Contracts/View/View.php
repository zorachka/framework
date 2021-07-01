<?php

declare(strict_types=1);

namespace Zorachka\Contracts\View;

use Psr\Http\Message\ResponseInterface;

interface View
{
    /**
     * @param string $name
     * @param array $context
     * @return ResponseInterface
     */
    public function response(string $name, array $context = []): ResponseInterface;
}
