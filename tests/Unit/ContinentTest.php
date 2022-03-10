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

        app(Continent::class)->findByName('not a continent');
    }

    /** @test */
    public function it_is_retrievable_by_code()
    {
        $continent_by_code = app(Continent::class)->findByCode($this->testContinent->code);

        $this->assertEquals($this->testContinent->code, $continent_by_code->code);
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
    public function it_is_retrievable_by_slug()
    {
        $continent_by_slug = app(Continent::class)->findBySlug($this->testContinent->slug);

        $this->assertEquals($this->testContinent->slug, $continent_by_slug->slug);
    }
}
