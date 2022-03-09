<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class CurrencyDoesNotExist extends InvalidArgumentException
{
    public static function named(string $currencyName)
    {
        return new static("There is no currency named `{$currencyName}`.");
    }

    public static function withId(int $currencyId)
    {
        return new static("There is no currency with id `{$currencyId}`.");
    }

    public static function withIso(int|string $currencyIso)
    {
        return new static("There is no currency with iso code `{$currencyIso}`.");
    }
}
