<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Papposilene\Geodata\Contracts\Subcontinent as SubcontinentContract;
use Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Subcontinent extends Model implements SubcontinentContract
{
    public function __construct()
    {
    }

    public function getTable()
    {
        return 'geodata__subcontinents';
    }

    /**
     * @inheritDoc
     */
    public function belongsToContinent(): BelongsTo
    {
        return $this->belongsTo(
            Continent::class,
            'id',
            'continent_idid'
        );
    }

    /**
     * @inheritDoc
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
     * Get the current subcontinents.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function getSubcontinents(array $params = [], bool $onlyOne = false): Collection
    {
        return app(GeodataRegistrar::class)
            ->setSubcontinentClass(static::class)
            ->getSubcontinents($params, $onlyOne);
    }

    /**
     * Get the current first subcontinent.
     *
     * @param array $params
     *
     * @return \Papposilene\Geodata\Contracts\Continent
     */
    protected static function getSubcontinent(array $params = []): ?SubcontinentContract
    {
        return static::getSubcontinents($params, true)->first();
    }

    /**
     * @inheritDoc
     */
    public static function findByName(string $name): SubcontinentContract
    {
        $subccontinent = static::findByName($name);

        if (!$subccontinent) {
            throw SubcontinentDoesNotExist::named($name);
        }

        return $subccontinent;
    }

    /**
     * @inheritDoc
     */
    public static function findById(int $id): SubcontinentContract
    {
        $subccontinent = static::findById($id);

        if (!$subccontinent) {
            throw SubcontinentDoesNotExist::withId($id);
        }

        return $subccontinent;
    }
}
