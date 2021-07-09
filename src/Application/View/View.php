<?php

declare(strict_types=1);

namespace Zorachka\Application\View;

use Psr\Http\Message\ResponseInterface;

interface View
{
    /**
     * Wrapper around Templer to make less boilerplate if you need a html view
     * @param string $name
     * @param array $context
     * @return ResponseInterface
     */
    public function response(string $name, array $context = []): ResponseInterface;
}
