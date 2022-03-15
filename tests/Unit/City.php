<?php

namespace Papposilene\Geodata\Tests;

class ContiCitynent extends \Papposilene\Geodata\Models\Continent
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
