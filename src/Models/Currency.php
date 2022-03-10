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
     * Get the current currencies.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function getCurrencies(array $params = [], bool $onlyOne = false): Collection
    {
        return app(GeodataRegistrar::class)
            ->setCurrencyClass(static::class)
            ->getCurrencies($params, $onlyOne);
    }

    /**
     * Get the current first currency.
     *
     * @param array $params
     *
     * @return \Papposilene\Geodata\Models\Continent
     */
    protected static function getCurrency(array $params = []): Currency
    {
        return static::getCurrencies($params, true)->first();
    }

    /**
     * @inheritDoc
     */
    public static function findByName(string $name): Currency
    {
        $currency = static::where('name', $name);

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
        $currency = static::findById($id);

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
        $currency = static::findByIso($iso);

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
        $currency = static::findByIso($iso);

        if (!$currency) {
            throw CurrencyDoesNotExist::withIso($iso);
        }

        return $currency;
    }
}
