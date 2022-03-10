<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Papposilene\Geodata\Exceptions\TopologyDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Topology extends Model
{
    public function getTable()
    {
        return 'geodata__topologies';
    }

    /**
     * Get the current topologies.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function getTopologies(array $params = [], bool $onlyOne = false): Collection
    {
        return app(GeodataRegistrar::class)
            ->setTopologyClass(static::class)
            ->getTopologies($params, $onlyOne);
    }

    /**
     * Get the current first currency.
     *
     * @param array $params
     *
     * @return \Papposilene\Geodata\Contracts\Topology
     */
    protected static function getTopology(array $params = []): ?TopologyContract
    {
        return static::getTopologies($params, true)->first();
    }

    /**
     * @inheritDoc
     */
    public static function findByCca3(string $cca3): TopologyContract
    {
        $topology = static::findByCca3($cca3);

        if (!$topology) {
            throw TopologyDoesNotExist::withCode($cca3);
        }

        return $topology;
    }
}
