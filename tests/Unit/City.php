<?php

namespace Papposilene\Geodata\Tests;

class City extends \Papposilene\Geodata\Models\Continent
{
    protected $visible = [
        'id',
        'country_cca3',
        'state',
        'name',
        'lat',
        'lon',
        'postcodes',
        'extra',
    ];
}
