<?php

namespace Papposilene\Geodata\Tests;

class City extends \Papposilene\Geodata\Models\Continent
{
    protected $visible = [
        'uuid',
        'country_cca3',
        'region_uuid',
        'osm_id',
        'osm_admin_level',
        'osm_parents',
        'osm_type',
        'name_loc',
        'name_eng',
        'name_translations',
        'lat',
        'lon',
        'postcodes',
        'extra',
    ];
}
