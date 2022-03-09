<?php

namespace Papposilene\Geodata\Contracts;

interface Topology
{
    /**
     * Find a topology by the ISO code of a country.
     *
     * @param string $cca3
     *
     * @throws \Papposilene\Geodata\Exceptions\TopologyDoesNotExist
     *
     * @return Geodata
     */
    public static function findByCca3(string $cca3): self;
}
