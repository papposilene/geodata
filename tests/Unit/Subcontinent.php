<?php

namespace Papposilene\Geodata\Tests;

class Subcontinent extends \Papposilene\Geodata\Models\Subcontinent
{
    protected $visible = [
        'id',
        'name',
        'slug',
        'continent_id'
    ];
}
