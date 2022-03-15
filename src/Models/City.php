<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Papposilene\Geodata\Exceptions\CityDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class City extends Model
{
    public function getTable()
    {
        return 'geodata__cities';
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
     * @inheritDoc
     */
    public function belongsToCountry(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'cca3',
            'country_cca3'
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
    protected static function getCities(array $params = [], bool $onlyOne = false): Collection
    {
        return app(GeodataRegistrar::class)
            ->setCityClass(static::class)
            ->getCities($params, $onlyOne);
    }

    /**
     * Get the current first country.
     *
     * @param array $params
     *
     * @return \Papposilene\Geodata\Contracts\City
     */
    protected static function getCity(array $params = []): City
    {
        return static::getCities($params, true)->first();
    }

    /**
     * @inheritDoc
     */
    public static function findById(int $id): City
    {
        $city = static::find($id);

        if (!$city) {
            throw CityDoesNotExist::withId($id);
        }

        return $city;
    }

    /**
     * @inheritDoc
     */
    public static function findByName(string $name): City
    {
        $city = self::where('name', $name)->first();

        if (!$city) {
            throw CityDoesNotExist::named($name);
        }

        return $city;
    }

    /**
     * @inheritDoc
     */
    public static function findByState(string $name, string $state): City
    {
        $city = self::where([
            ['name', $name],
            ['state', $state]
        ])->first();

        if (!$city) {
            throw CityDoesNotExist::withState($name, $state);
        }

        return $city;
    }

    /**
     * @inheritDoc
     */
    public static function findByPostcodes(array $postcodes)
    {
        dd(self::getCities(['postcodes' => 75001]));

        $city = self::getCities(['postcodes' => $postcodes]);

        if (!$city) {
            throw CityDoesNotExist::withPostcodes($postcodes);
        }

        return $city;
    }
}
