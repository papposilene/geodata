<?php

namespace Papposilene\Geodata\Tests;

class Region extends \Papposilene\Geodata\Models\Continent
{
    protected $visible = [
        'uuid',
        'country_cca2',
        'country_cca3',
        'region_cca2',
        'osm_id',
        'osm_place_id',
        'osm_admin_level',
        'osm_type',
        'name_loc',
        'name_eng',
        'name_translations',
        'extra',
    ];
}
