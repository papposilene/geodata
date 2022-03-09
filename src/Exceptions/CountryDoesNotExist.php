<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class CountryDoesNotExist extends InvalidArgumentException
{
    public static function named(string $countryName)
    {
        return new static("There is no country named `{$countryName}`.");
    }

    public static function withId(int $countryId)
    {
        return new static("There is no country with id `{$countryId}`.");
    }

    public static function withCca2(string $cca2)
    {
        return new static("There is no country with CCA2 `{$cca2}`.");
    }

    public static function withCca3(string $cca3)
    {
        return new static("There is no country with CCA3 `{$cca3}`.");
    }
}
