<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class CurrencyDoesNotExist extends InvalidArgumentException
{
    public static function create(string $currencyName)
    {
        return new static("There is no currency named `{$currencyName}`.");
    }

    public static function withId(int $currencyId)
    {
        return new static("There is no [currency] with id `{$currencyId}`.");
    }
}
