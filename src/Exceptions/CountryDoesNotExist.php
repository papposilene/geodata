<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class CountryDoesNotExist extends InvalidArgumentException
{
    public static function create(string $countryName)
    {
        return new static("There is no country named `{$countryName}`.");
    }

    public static function withId(int $countryId)
    {
        return new static("There is no [country] with id `{$countryId}`.");
    }
}
