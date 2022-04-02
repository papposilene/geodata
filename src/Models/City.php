<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'uuid' => 'uuid',
        'extra' => 'array',
    ];

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
        'region_uuid',
        'osm_id',
        'osm_admin_level',
        'osm_type',
        'state',
        'name',
        'lat',
        'lon',
        'postcodes',
        'extra',
    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'uuid',
        'country_cca3',
        'region_uuid',
        'osm_id',
        'osm_admin_level',
        'osm_type',
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
     * A city belongs to one country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
     * A city belongs to one region.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToRegion(): BelongsTo
    {
        return $this->belongsTo(
            Region::class,
            'region_uuid',
            'uuid'
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
     * @return City
     */
    protected static function getCity(array $params = []): City
    {
        return static::getCities($params, true)->first();
    }

    /**
     * Find a city by its uuid.
     *
     * @param string $uuid
     *
     * @throws \Papposilene\Geodata\Exceptions\CityDoesNotExist
     *
     * @return City
     */
    public static function findById(string $uuid): City
    {
        $city = static::find($uuid);

        if (!$city) {
            throw CityDoesNotExist::withId($uuid);
        }

        return $city;
    }

    /**
     * Find a city by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\CityDoesNotExist
     *
     * @return City
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
     * Find a city by its state.
     *
     * @param string $name
     * @param string $state
     *
     * @throws \Papposilene\Geodata\Exceptions\CityDoesNotExist
     *
     * @return City
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
     * Find a city by its postcodes.
     *
     * @param array $postcodes
     *
     * @throws \Papposilene\Geodata\Exceptions\CityDoesNotExist
     *
     * @return \Illuminate\Database\Eloquent\Collection
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
