<?php

namespace Papposilene\Geodata\Exceptions;

use InvalidArgumentException;

class ContinentDoesNotExist extends InvalidArgumentException
{
    /**
     * Returns an InvalidArgumentException for the specified name
     *
     * @param string $name The name of the unknown continent
     *
     * @return ContinentDoesNotExist
     */
    public static function named(string $name)
    {
        return new static("There is no continent named `{$name}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified code
     *
     * @param int $code The code of the unknown continent
     *
     * @return ContinentDoesNotExist
     */
    public static function withCode(int $code)
    {
        return new static("There is no continent with id `{$code}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified id
     *
     * @param int $id The id of the unknown continent
     *
     * @return ContinentDoesNotExist
     */
    public static function withId(int $id)
    {
        return new static("There is no continent with id `{$id}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified slug
     *
     * @param string $slug The slug of the unknown continent
     *
     * @return ContinentDoesNotExist
     */
    public static function withSlug(string $slug)
    {
        return new static("There is no continent with slug `{$slug}`.");
    }
}
