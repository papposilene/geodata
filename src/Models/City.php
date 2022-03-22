<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Papposilene\Geodata\Exceptions\CityDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class City extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $primaryKey = 'uuid';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'laravel_through_key',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_cca3',
        'state',
        'name',
        'lat',
        'lon',
        'postcodes',
        'extra',
    ];

    public function getTable()
    {
        return 'geodata__cities';
    }

    /**
     * Boot the Model.
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * @inheritDoc
     */
    public function belongsToCountry(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'country_cca3',
            'cca3'
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
        $city = self::getCities($postcodes);

        if (!$city) {
            throw CityDoesNotExist::withPostcodes($postcodes);
        }

        return $city;
    }
}
