<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Papposilene\Geodata\Contracts\Continent as ContinentContract;
use Papposilene\Geodata\Exceptions\ContinentDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Continent extends Model implements ContinentContract
{
    public function __construct()
    {
    }

    public function getTable()
    {
        return 'geodata__continents';
    }

    /**
     * @inheritDoc
     */
    public function hasSubcontinents(): HasMany
    {
        return $this->hasMany(
            Subcontinent::class,
            'continent_id',
            'id'
        );
    }

    /**
     * @inheritDoc
     */
    public function hasCountries(): HasMany
    {
        return $this->hasMany(
            Country::class,
            'continent_id',
            'id'
        );
    }

    /**
     * Get the current continents.
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
     * Get the current first continent.
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
     * @inheritDoc
     */
    public static function findByName(string $name): ContinentContract
    {
        $continent = static::findByName($name);

        if (!$continent) {
            throw ContinentDoesNotExist::named($name);
        }

        return $continent;
    }

    /**
     * @inheritDoc
     */
    public static function findById(int $id): ContinentContract
    {
        $continent = static::findById($id);

        if (!$continent) {
            throw ContinentDoesNotExist::withId($id);
        }

        return $continent;
    }
}
