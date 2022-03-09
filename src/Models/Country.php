<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Papposilene\Geodata\Contracts\Country as CountryContract;
use Papposilene\Geodata\Exceptions\CountryDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Country extends Model implements CountryContract
{
    public function __construct()
    {
    }

    public function getTable()
    {
        return 'geodata__countries';
    }

    /**
     * @inheritDoc
     */
    public function belongsToContinent(): BelongsTo
    {
        return $this->belongsTo(
            Continent::class,
            'id',
            'continent_id'
        );
    }

    /**
     * @inheritDoc
     */
    public function belongsToSubcontinent(): BelongsTo
    {
        return $this->belongsTo(
            Continent::class,
            'id',
            'subcontinent_id'
        );
    }

    /**
     * Get the current countries.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function getCountries(array $params = [], bool $onlyOne = false): Collection
    {
        return app(GeodataRegistrar::class)
            ->setCountryClass(static::class)
            ->getCountries($params, $onlyOne);
    }

    /**
     * Get the current first country.
     *
     * @param array $params
     *
     * @return \Papposilene\Geodata\Contracts\Country
     */
    protected static function getCountry(array $params = []): ?CountryContract
    {
        return static::getCountries($params, true)->first();
    }

    /**
     * @inheritDoc
     */
    public static function findByName(string $name): CountryContract
    {
        $country = static::findByName($name);

        if (!$country) {
            throw CountryDoesNotExist::named($name);
        }

        return $country;
    }

    /**
     * @inheritDoc
     */
    public static function findById(int $id): CountryContract
    {
        $country = static::findById($id);

        if (!$country) {
            throw CountryDoesNotExist::withId($id);
        }

        return $country;
    }

    /**
     * @inheritDoc
     */
    public static function findByCca2(string $cca2): CountryContract
    {
        $country = static::findByCca2($cca2);

        if (!$country) {
            throw CountryDoesNotExist::withCca2($cca2);
        }

        return $country;
    }

    /**
     * @inheritDoc
     */
    public static function findByCca3(string $cca3): CountryContract
    {
        $country = static::findByCca3($cca3);

        if (!$country) {
            throw CountryDoesNotExist::withCca3($cca3);
        }

        return $country;
    }
}
