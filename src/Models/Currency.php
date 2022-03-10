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
     * @inheritDoc
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
     * @inheritDoc
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
     * @inheritDoc
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
     * @inheritDoc
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
     * @inheritDoc
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
