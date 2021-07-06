<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer\Twig;

use Twig\Environment;
use Zorachka\Contracts\Application\Templer\Templer;

final class TwigTempler implements Templer
{
    /**
     * @var Environment
     */
    private Environment $templer;

    /**
     * TwigTempler constructor.
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->templer = $environment;
    }

    /**
     * @inheritDoc
     */
    public function render(string $name, array $context = []): string
    {
        return $this->templer->render($name . $this->getExtension(), $context);
    }

    /**
     * @inheritDoc
     */
    public function getExtension(): string
    {
        return '.html.twig';
    }
}
