<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Papposilene\Geodata\Exceptions\CurrencyDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Currency extends Model
{
    public function getTable()
    {
        return 'geodata__currencies';
    }

    /**
     * A currency can be used by many countries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usedByCountries(): belongsToMany
    {
        return $this->belongsToMany(
            Country::class,
            'iso3l',
            'object->currencies',
        );
    }

    /**
     * Find a continent by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return Currency
     */
    public static function findByName(string $name): Currency
    {
        $currency = static::where('name', $name)->first();

        if (!$currency) {
            throw CurrencyDoesNotExist::named($name);
        }

        return $currency;
    }

    /**
     * Find a continent by its id.
     *
     * @param int $id
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return Currency
     */
    public static function findById(int $id): Currency
    {
        $currency = static::find($id);

        if (!$currency) {
            throw CurrencyDoesNotExist::withId($id);
        }

        return $currency;
    }

    /**
     * Find a continent by its 3-letter ISO.
     *
     * @param string $iso3n
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return Currency
     */
    public static function findByIso3l(string $iso): Currency
    {
        $currency = static::where('iso3l', $iso)->first();

        if (!$currency) {
            throw CurrencyDoesNotExist::withIso($iso);
        }

        return $currency;
    }

    /**
     * Find a continent by its 3-number ISO.
     *
     * @param int $iso3n
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return Currency
     */
    public static function findByIso3n(int $iso): Currency
    {
        $currency = static::where('iso3n', $iso)->first();

        if (!$currency) {
            throw CurrencyDoesNotExist::withIso($iso);
        }

        return $currency;
    }
}
