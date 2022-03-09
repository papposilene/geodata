<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Papposilene\Geodata\Contracts\Geometry as GeometryContract;
use Papposilene\Geodata\Exceptions\GeometryDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Geometry extends Model implements GeometryContract
{
    public function __construct()
    {
    }

    public function getTable()
    {
        return 'geodata__geometries';
    }

    /**
     * Get the current geometries.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function getGeometries(array $params = [], bool $onlyOne = false): Collection
    {
        return app(GeodataRegistrar::class)
            ->setGeometryClass(static::class)
            ->getGeometries($params, $onlyOne);
    }

    /**
     * Get the current first currency.
     *
     * @param array $params
     *
     * @return \Papposilene\Geodata\Contracts\Geometry
     */
    protected static function getGeometry(array $params = []): ?GeometryContract
    {
        return static::getGeometries($params, true)->first();
    }

    /**
     * @inheritDoc
     */
    public static function findByCca3(string $cca3): GeometryContract
    {
        $geometry = static::findByCca3($cca3);

        if (!$geometry) {
            throw GeometryDoesNotExist::withCode($cca3);
        }

        return $geometry;
    }
}
