<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class TopologyDoesNotExist extends InvalidArgumentException
{
    public static function named(string $topologyName)
    {
        return new static("There is no topology named `{$topologyName}`.");
    }

    public static function withId(int $topologyId)
    {
        return new static("There is no topology with id `{$topologyId}`.");
    }
}
