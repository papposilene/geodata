<?php

namespace Papposilene\Geodata\Contracts;

interface Geometry
{
    /**
     * Find a geometry by the ISO code of a country.
     *
     * @param string $cca3
     *
     * @throws \Papposilene\Geodata\Exceptions\GeometryDoesNotExist
     *
     * @return Geodata
     */
    public static function findByCca3(string $cca3): self;
}
