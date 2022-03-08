<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class GeometryDoesNotExist extends InvalidArgumentException
{
    public static function named(string $geometryName)
    {
        return new static("There is no geometry named `{$geometryName}`.");
    }

    public static function withId(int $geometryId)
    {
        return new static("There is no geometry with id `{$geometryId}`.");
    }
}
