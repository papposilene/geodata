<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class RegionDoesNotExist extends InvalidArgumentException
{
    public static function named(string $regionName)
    {
        return new static("There is no administrative level named `{$regionName}`.");
    }

    public static function withId(string $regionId)
    {
        return new static("There is no administrative level with uuid `{$regionId}`.");
    }

    public static function withCca2(string $cca2)
    {
        return new static("There is no administrative level with CCA2 `{$cca2}`.");
    }
}
