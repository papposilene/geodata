<?php

namespace Papposilene\Geodata\Tests;

use Papposilene\Geodata\Contracts\Geometry;
use Papposilene\Geodata\Exceptions\GeometryDoesNotExist;

class GeometryTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_when_a_geometry_file_does_not_exist()
    {
        $this->expectException(GeometryDoesNotExist::class);

        app(Currency::class)->where('name', 'not a currency')->isEmpty();
    }
}
