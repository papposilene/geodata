<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class CityDoesNotExist extends InvalidArgumentException
{
    public static function named(string $name)
    {
        return new static("There is no city named `{$name}`.");
    }

    public static function withId(int $id)
    {
        return new static("There is no city with id `{$id}`.");
    }

    public static function withState(string $name, string $state)
    {
        return new static("There is no city named `{$name}` in the state `{$state}`.");
    }

    public static function withPostcodes(array|string $postcodes)
    {
        return new static("There is no city with postcodes as `{$postcodes}`.");
    }
}
