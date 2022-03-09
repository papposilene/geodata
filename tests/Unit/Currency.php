<?php

namespace Papposilene\Geodata\Tests;

class Currency extends \Papposilene\Geodata\Models\Currency
{
    protected $visible = [
        'id',
        'name',
        'iso3l',
        'iso3n',
        'type',
        'units',
        'coins',
        'bills',
    ];
}
