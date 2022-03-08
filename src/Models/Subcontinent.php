<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Papposilene\Geodata\Contracts\Subcontinent as SubcontinentContract;
use Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Subcontinent extends Model implements SubcontinentContract
{
    use HasRoles;

    public function __construct() { }

    public function getTable()
    {
        return 'geodata__continents';
    }

    /**
     * A subcontinent belongs to a continent.
     */
    public function belongsToContinent(): HasOne
    {
        return $this->hasOne(
            Continent::class,
            'continent',
            'id'
        );
    }

    /**
     * A subcontinent can have many countries.
     */
    public function hasCountries(): HasMany
    {
        return $this->hasMany(
            Country::class,
            'subcontinent_id',
            'id'
        );
    }

    /**
     * Find a subcontinent by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist
     *
     * @return \Papposilene\Geodata\Contracts\Subcontinent
     */
    public static function findByName(string $name): SubcontinentContract
    {
        $subcontinent = static::getSubcontinent(['id' => $id]);

        if (! $subcontinent) {
            throw SubcontinentDoesNotExist::withName($id);
        }

        return $subcontinent;
    }

    /**
     * Find a subcontinent by its id.
     *
     * @param int $id
     *
     * @throws \Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist
     *
     * @return \Papposilene\Geodata\Contracts\Subcontinent
     */
    public static function findById(int $id): SubcontinentContract
    {
        $subcontinent = static::getSubcontinent(['id' => $id]);

        if (! $subcontinent) {
            throw SubcontinentDoesNotExist::withId($id);
        }

        return $subcontinent;
    }

    /**
     * Find a subcontinent by its name.
     *
     * @param string $name
     *
     * @return \Papposilene\Geodata\Contracts\Subcontinent
     */
    public static function findOrCreate(string $name): SubcontinentContract
    {
        $subcontinent = static::getSubcontinent(['name' => $name]);

        if (! $subcontinent) {
            throw SubcontinentDoesNotExist::withName($name);
        }

        return $subcontinent;
    }
}
