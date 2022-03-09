<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class SubcontinentDoesNotExist extends InvalidArgumentException
{
    public static function named(string $subContinentName)
    {
        return new static("There is no subcontinent named `{$subContinentName}`.");
    }

    public static function withId(int $subContinentId)
    {
        return new static("There is no [subcontinent] with id `{$subContinentId}`.");
    }
}
