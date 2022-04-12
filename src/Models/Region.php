<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Papposilene\Geodata\Exceptions\RegionDoesNotExist;
use Papposilene\Geodata\GeodataRegistrar;

class Region extends Model
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
        'country_cca2',
        'country_cca3',
        'region_cca2',
        'osm_id',
        'osm_place_id',
        'osm_admin_level',
        'osm_type',
        'name_local',
        'name_slug',
        'name_translations',
        'extra',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatable = [
        'name_translations'
    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'uuid',
        'country_cca2',
        'country_cca3',
        'region_cca2',
        'osm_id',
        'osm_place_id',
        'osm_admin_level',
        'osm_type',
        'name_local',
        'name_slug',
        'name_translations',
        'extra',
    ];

    public function getTable()
    {
        return 'geodata__regions';
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
     * A region belongs to one country.
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
     * Get the current regions.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function getRegions(array $params = [], bool $onlyOne = false): Collection
    {
        return app(GeodataRegistrar::class)
            ->setRegionClass(static::class)
            ->getRegions($params, $onlyOne);
    }

    /**
     * Get the current first region.
     *
     * @param array $params
     *
     * @return Region
     */
    protected static function getRegion(array $params = []): Region
    {
        return static::getRegions($params, true)->first();
    }

    /**
     * Find a region by its name.
     *
     * @param string $name
     *
     * @return Region
     */
    public static function findByName(string $name): Region
    {
        $region = static::find($name);

        if (!$region) {
            throw RegionDoesNotExist::named($name);
        }

        return $region;
    }

    /**
     * Find a region by its slug.
     *
     * @param string $slug
     *
     * @return Region
     */
    public static function findBySlug(string $slug): Region
    {
        $region = static::find($slug);

        if (!$region) {
            throw RegionDoesNotExist::sluged($slug);
        }

        return $region;
    }

    /**
     * Find a region by its uuid.
     *
     * @param string $uuid
     *
     * @return Region
     */
    public static function findById(string $uuid): Region
    {
        $region = static::findById($uuid);

        if (!$region) {
            throw RegionDoesNotExist::withId($id);
        }

        return $region;
    }

    /**
     * Find a region by its CCA2 iso code.
     *
     * @param string $cca2
     *
     * @return Region
     */
    public static function findByCca2(string $cca2): Region
    {
        $region = static::findByCca2($cca2);

        if (!$region) {
            throw RegionDoesNotExist::withCca2($cca2);
        }

        return $region;
    }

}
