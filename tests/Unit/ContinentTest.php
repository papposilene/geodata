<?php

namespace Papposilene\Geodata\Tests;

use Papposilene\Geodata\Models\Continent;
use Papposilene\Geodata\Exceptions\ContinentDoesNotExist;

class ContinentTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_when_a_continent_does_not_exist()
    {
        $this->expectException(ContinentDoesNotExist::class);

        app(Continent::class)->where('name', 'not a continent')->isEmpty();
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $continent_by_id = app(Continent::class)->findById($this->testContinent->id);

        $this->assertEquals($this->testContinent->id, $continent_by_id->id);
    }

    /** @test */
    public function it_is_retrievable_by_name()
    {
        $continent_by_name = app(Continent::class)->findByName($this->testContinent->name);

        $this->assertEquals($this->testContinent->name, $continent_by_name->name);
    }

    /** @test */
    public function it_is_retrievable_by_iso3l()
    {
        $continent_by_iso3l = app(Continent::class)->findByIso($this->testContinent->iso3l);

        var_dump($this->testContinent);

        $this->assertEquals($this->testContinent->iso3l, $continent_by_iso3l->iso3l);
    }
}
