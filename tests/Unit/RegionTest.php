<?php

namespace Papposilene\Geodata\Tests;

use Papposilene\Geodata\Models\Region;
use Papposilene\Geodata\Exceptions\RegionDoesNotExist;

class RegionTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_when_a_region_does_not_exist()
    {
        $this->expectException(RegionDoesNotExist::class);

        app(Region::class)->findByName('not a administrative level');
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $region_by_id = app(Region::class)->findById($this->testRegion->uuid);

        $this->assertEquals($this->testRegion->uuid, $region_by_id->uuid);
    }

    /** @test */
    public function it_is_retrievable_by_name()
    {
        $region_by_name = app(Region::class)->findByName($this->testRegion->name_loc);

        $this->assertEquals($this->testRegion->name_loc, $region_by_name->name_loc);
    }

    /** @test */
    public function it_is_retrievable_by_cca2()
    {
        $region_by_state = app(Region::class)->findByCca2($this->testRegion->region_cca2);

        $this->assertEquals($this->testRegion->region_cca2, $region_by_state->region_cca2);
    }

    /** @test */
    public function it_belongs_to_a_country()
    {
        $region_by_country = app(Region::class)->find($this->testRegion->uuid)->belongsToCountry;

        $this->assertEquals($this->testRegion->country_cca3, $region_by_country->cca3);
    }

}
