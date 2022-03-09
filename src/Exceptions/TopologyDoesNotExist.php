<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class TopologyDoesNotExist extends InvalidArgumentException
{
    public static function withCca3(string $cca3)
    {
        return new static("There is no topology for the country with ISO code `{$cca3}`.");
    }

    public static function noFile(string $cca3)
    {
        return new static("There is no topology file for the country with ISO code `{$cca3}`.");
    }
}
