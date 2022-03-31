<?php

namespace Papposilene\Geodata\Tests;

class Region extends \Papposilene\Geodata\Models\Continent
{
    protected $visible = [
        'uuid',
        'country_cca2',
        'country_cca3',
        'region_cca2',
        'osm_place_id',
        'admin_level',
        'name_loc',
        'name_eng',
        'name_translations',
        'extra',
    ];
}
