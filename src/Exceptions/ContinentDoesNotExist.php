<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class ContinentDoesNotExist extends InvalidArgumentException
{
    public static function create(string $continentName)
    {
        return new static("There is no continent named `{$continentName}`.");
    }

    public static function withId(int $continentId)
    {
        return new static("There is no [continent] with id `{$continentId}`.");
    }
}
