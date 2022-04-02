<?php

namespace Papposilene\Geodata\Tests;

class City extends \Papposilene\Geodata\Models\Continent
{
    protected $visible = [
        'id',
        'country_cca3',
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
