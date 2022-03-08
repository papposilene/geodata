<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Papposilene\Geodata\Contracts\Continent as ContinentContract;
use Papposilene\Geodata\Exceptions\ContinentDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Continent extends Model implements ContinentContract
{
    use HasRoles;

    public function __construct() { }

    public function getTable()
    {
        return 'geodata__continents';
    }

    /**
     * A continent can be used in many countries.
     */
    public function belongsToContinents(): BelongsToMany
    {
        return $this->belongsToMany(
            Countries::class,
            'continent',
            'id'
        );
    }

    /**
     * Get the current cached continents.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function getContinents(array $params = [], bool $onlyOne = false): Collection
    {
        return app(GeodataRegistrar::class)
            ->setContinentClass(static::class)
            ->getContinents($params, $onlyOne);
    }

    /**
     * Get the current cached first continent.
     *
     * @param array $params
     *
     * @return \Papposilene\Geodata\Contracts\Continent
     */
    protected static function getContinent(array $params = []): ?ContinentContract
    {
        return static::getContinents($params, true)->first();
    }

    /**
     * Find a continent by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\ContinentDoesNotExist
     *
     * @return \Papposilene\Geodata\Contracts\Continent
     */
    public static function findByName(string $name): ContinentContract
    {
        $continent = static::findByName(['name' => $name]);

        if (! $continent) {
            throw ContinentDoesNotExist::named($name);
        }

        return $continent;
    }

    /**
     * Find a continent by its id.
     *
     * @param int $id
     *
     * @throws \Papposilene\Geodata\Exceptions\ContinentDoesNotExist
     *
     * @return \Papposilene\Geodata\Contracts\Continent
     */
    public static function findById(int $id): ContinentContract
    {
        $continent = static::findById(['id' => $id]);

        if (! $continent) {
            throw ContinentDoesNotExist::withId($id);
        }

        return $continent;
    }



}
