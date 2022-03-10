<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Papposilene\Geodata\Exceptions\ContinentDoesNotExist;

class Continent extends Model
{
    protected $visible = [
        'id',
        'code',
        'name',
        'slug',
        'region',
        'translations',
    ];

    public function getTable()
    {
        return 'geodata__continents';
    }

    /**
     * A continent has many subcontinents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
     * A continent has many countries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
     * Find a continent by its code.
     *
     * @param integer $code
     *
     * @throws \Papposilene\Geodata\Exceptions\ContinentDoesNotExist
     *
     * @return Continent
     */
    public static function findByCode(int $code): Continent
    {
        $continent = static::where('code', $code)->first();

        if (!$continent) {
            throw ContinentDoesNotExist::withCode($code);
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
     * @return Continent
     */
    public static function findById(int $id): Continent
    {
        $continent = static::find($id);

        if (!$continent) {
            throw ContinentDoesNotExist::withId($id);
        }

        return $continent;
    }

    /**
     * Find a continent by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\ContinentDoesNotExist
     *
     * @return Continent
     */
    public static function findByName(string $name): Continent
    {
        $continent = self::where('name', $name)->first();

        if (!$continent) {
            throw ContinentDoesNotExist::named($name);
        }

        return $continent;
    }

    /**
     * Find a continent by its slug.
     *
     * @param string $slug
     *
     * @throws \Papposilene\Geodata\Exceptions\ContinentDoesNotExist
     *
     * @return Continent
     */
    public static function findBySlug(string $slug): Continent
    {
        $continent = self::where('slug', $slug)->first();

        if (!$continent) {
            throw ContinentDoesNotExist::withSlug($slug);
        }

        return $continent;
    }
}
