<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Papposilene\Geodata\Contracts\Currency as CurrencyContract;
use Papposilene\Geodata\Exceptions\CurrencyDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Currency extends Model implements CurrencyContract
{
    use HasRoles;

    public function __construct() { }

    public function getTable()
    {
        return 'geodata__currencies';
    }

    /**
     * A currency can be used in many countries.
     */
    public function belongsToCurrencies(): BelongsToMany
    {
        return $this->belongsToMany(
            Countries::class,
            'continent',
            'id'
        );
    }

    /**
     * Get the current cached currencies.
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
     * Get the current cached first currency.
     *
     * @param array $params
     *
     * @return \Papposilene\Geodata\Contracts\Currency
     */
    protected static function getCurrency(array $params = []): ?CurrencyContract
    {
        return static::getCurrencies($params, true)->first();
    }

    /**
     * Find a currency by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return \Papposilene\Geodata\Contracts\Currency
     */
    public static function findByName(string $name): CurrencyContract
    {
        $currency = static::findByName(['name' => $name]);

        if (! $currency) {
            throw CurrencyDoesNotExist::named($name);
        }

        return $currency;
    }

    /**
     * Find a currency by its id.
     *
     * @param int $id
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return \Papposilene\Geodata\Contracts\Currency
     */
    public static function findById(int $id): CurrencyContract
    {
        $currency = static::findById(['id' => $id]);

        if (! $currency) {
            throw CurrencyDoesNotExist::withId($id);
        }

        return $currency;
    }

    /**
     * Find a currency by its iso codes.
     *
     * @param string $iso
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return \Papposilene\Geodata\Contracts\Currency
     */
    public static function findByIso(string $iso): CurrencyContract
    {
        $currency = static::findByIso(['iso3l' => $iso]);

        if (! $currency) {
            throw CurrencyDoesNotExist::withIso($iso);
        }

        return $currency;
    }


}
