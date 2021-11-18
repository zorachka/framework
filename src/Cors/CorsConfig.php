<?php

declare(strict_types=1);

namespace Zorachka\Framework\Cors;

final class CorsConfig
{
    private array $allowedHeaders;
    private array $allowedMethods;
    private array $allowedOrigins;
    private array $allowedOriginsPatterns;
    private array $exposedHeaders;
    private int $maxAge;
    private bool $supportsCredentials;

    public function __construct(
        array $allowedHeaders,
        array $allowedMethods,
        array $allowedOrigins,
        array $allowedOriginsPatterns,
        array $exposedHeaders,
        int $maxAge,
        bool $supportsCredentials,
    ) {
        $this->allowedHeaders = $allowedHeaders;
        $this->allowedMethods = $allowedMethods;
        $this->allowedOrigins = $allowedOrigins;
        $this->allowedOriginsPatterns = $allowedOriginsPatterns;
        $this->exposedHeaders = $exposedHeaders;
        $this->maxAge = $maxAge;
        $this->supportsCredentials = $supportsCredentials;
    }

    public static function withDefaults(
        array $allowedHeaders = [],
        array $allowedMethods = [],
        array $allowedOrigins = [],
        array $allowedOriginsPatterns = [],
        array $exposedHeaders = [],
        int $maxAge = 0,
        bool $supportsCredentials = false,
    ): self {
        return new self(
            $allowedHeaders,
            $allowedMethods,
            $allowedOrigins,
            $allowedOriginsPatterns,
            $exposedHeaders,
            $maxAge,
            $supportsCredentials
        );
    }

    /**
     * @return array
     */
    public function allowedHeaders(): array
    {
        return $this->allowedHeaders;
    }

    public function withAllowedHeaders(array $allowedHeaders): self
    {
        $new = clone $this;
        $new->allowedHeaders = $allowedHeaders;

        return $new;
    }

    /**
     * @return array
     */
    public function allowedMethods(): array
    {
        return $this->allowedMethods;
    }

    public function withAllowedMethods(array $allowedMethods): self
    {
        $new = clone $this;
        $new->allowedMethods = $allowedMethods;

        return $new;
    }

    /**
     * @return array
     */
    public function allowedOrigins(): array
    {
        return $this->allowedOrigins;
    }

    public function withAllowedOrigins(array $allowedOrigins): self
    {
        $new = clone $this;
        $new->allowedOrigins = $allowedOrigins;

        return $new;
    }

    /**
     * @return array
     */
    public function allowedOriginsPatterns(): array
    {
        return $this->allowedOriginsPatterns;
    }

    /**
     * @return array
     */
    public function exposedHeaders(): array
    {
        return $this->exposedHeaders;
    }

    /**
     * @return int
     */
    public function maxAge(): int
    {
        return $this->maxAge;
    }

    /**
     * @return bool
     */
    public function supportsCredentials(): bool
    {
        return $this->supportsCredentials;
    }

    public function withSupportsCredentials(bool $supportsCredentials): self
    {
        $new = clone $this;
        $new->supportsCredentials = $supportsCredentials;

        return $new;
    }
}
