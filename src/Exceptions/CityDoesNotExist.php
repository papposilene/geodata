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

    public static function withPostcode(string $name, string $postcode)
    {
        return new static("There is no city named `{$name}` in the country `{$postcode}`.");
    }

    public static function withCca3(string $name, string $cca3)
    {
        return new static("There is no city named `{$name}` in the country `{$cca3}`.");
    }
}
