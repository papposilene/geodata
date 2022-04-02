<?php

namespace Papposilene\Geodata\Tests;

class City extends \Papposilene\Geodata\Models\Continent
{
    protected $visible = [
        'uuid',
        'country_cca3',
        'region_uuid',
        'osm_id',
        'admin_level',
        'state',
        'name',
        'lat',
        'lon',
        'postcodes',
        'extra',
    ];
}
