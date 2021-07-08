<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner\Factory;

use Onliner\CommandBus\Remote\Serializer;
use Zorachka\Infrastructure\CommandBus\Onliner\Exception\UnknownSerializerException;

final class SerializerFactory
{
    public const DEFAULT = 'native';

    /**
     * @param string $type
     * @param array  $options
     *
     * @return Serializer
     */
    public static function create(string $type, array $options = []): Serializer
    {
        switch ($type) {
            case 'native':
                return new Serializer\NativeSerializer();
            default:
                throw new UnknownSerializerException($type);
        }
    }
}
