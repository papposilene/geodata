<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Papposilene\Geodata\Exceptions\CountryDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Country extends Model
{
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
        'continent_id',
        'subcontinent_id',
        'cca2',
        'cca3',
        'ccn3',
        'name_eng_common',
        'name_eng_formal',
        'lat',
        'lon',
        'landlocked',
        'neighbourhood',
        'status',
        'independent',
        'flag',
        'capital',
        'currencies',
        'demonyms',
        'dialling',
        'languages',
        'name_native',
        'name_translations',
        'extra',
    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'uuid',
        'continent_id',
        'subcontinent_id',
        'cca2',
        'cca3',
        'ccn3',
        'name_eng_common',
        'name_eng_formal',
        'lat',
        'lon',
        'landlocked',
        'neighbourhood',
        'status',
        'independent',
        'flag',
        'capital',
        'currencies',
        'demonyms',
        'dialling',
        'languages',
        'name_native',
        'name_translations',
        'extra',
    ];

    public function getTable()
    {
        return 'geodata__countries';
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
     * A country belongs to one continent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToContinent(): BelongsTo
    {
        return $this->belongsTo(
            Continent::class,
            'continent_id',
            'id'
        );
    }

    /**
     * A country belongs to one subcontinent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToSubcontinent(): BelongsTo
    {
        return $this->belongsTo(
            Continent::class,
            'subcontinent_id',
            'id'
        );
    }

    /**
     * A country has many cities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasCities(): HasMany
    {
        return $this->hasMany(
            City::class,
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
     * @return Country
     */
    protected static function getCountry(array $params = []): Country
    {
        return static::getCountries($params, true)->first();
    }

    /**
     * Find a country by its name.
     *
     * @param string $name
     *
     * @return Country
     */
    public static function findByName(string $name): Country
    {
        $country = static::find($name);

        if (!$country) {
            throw CountryDoesNotExist::named($name);
        }

        return $country;
    }

    /**
     * Find a country by its id.
     *
     * @param int $id
     *
     * @return Country
     */
    public static function findById(int $id): Country
    {
        $country = static::findById($id);

        if (!$country) {
            throw CountryDoesNotExist::withId($id);
        }

        return $country;
    }

    /**
     * Find a country by its CCA2 iso code.
     *
     * @param string $cca2
     *
     * @return Country
     */
    public static function findByCca2(string $cca2): Country
    {
        $country = static::findByCca2($cca2);

        if (!$country) {
            throw CountryDoesNotExist::withCca2($cca2);
        }

        return $country;
    }

    /**
     * Find a country by its CCA3 iso code.
     *
     * @param string $cca3
     *
     * @return Country
     */
    public static function findByCca3(string $cca3): Country
    {
        $country = static::findByCca3($cca3);

        if (!$country) {
            throw CountryDoesNotExist::withCca3($cca3);
        }

        return $country;
    }
}
