<?php

declare(strict_types=1);

namespace Zorachka\Framework\Environment;

final class EnvironmentVariables implements Environment
{
    private const VALUE_MAP = [
        'true'    => true,
        '(true)'  => true,
        'false'   => false,
        '(false)' => false,
        'null'    => null,
        '(null)'  => null,
        'empty'   => '',
    ];

    private array $values = [];

    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $values = $values + $_ENV + $_SERVER;
        foreach ($values as $name => $value) {
            $this->set($name, $value);
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    private function set(string $name, mixed $value): void
    {
        $this->values[$name] = $_ENV[$name] = $value;
        putenv("$name=$value");
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function normalize(mixed $value): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        $alias = strtolower($value);
        if (isset(self::VALUE_MAP[$alias])) {
            return self::VALUE_MAP[$alias];
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function get(string $name, $default = null): mixed
    {
        if (isset($this->values[$name])) {
            return $this->normalize($this->values[$name]);
        }

        return $default;
    }
}
