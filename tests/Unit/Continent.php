<?php

namespace Papposilene\Geodata\Tests;

class Continent extends \Papposilene\Geodata\Models\Continent
{
    protected $visible = [
        'id',
        'code',
        'name',
        'slug',
        'region',
        'translations',
    ];
}
