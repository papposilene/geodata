<?php

namespace Papposilene\Geodata\Test;

use Papposilene\Geodata\Contracts\Continent;
use Papposilene\Geodata\Contracts\Subcontinent;
use Papposilene\Geodata\Exceptions\ContinentDoesNotExist;
use Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist;

class ContinentTest extends TestCase
{
  /** @test */
  public function it_throws_an_exception_when_a_continent_does_not_exist()
  {
    $this->expectException(ContinentDoesNotExist::class);

    Continent::where('name', 'not a continent')->isEmpty();   
  }

  /** @test */
  public function it_is_retrievable_by_id()
  {
      $continent_by_id = app(Continent::class)->findById($this->testContinent->id);

      $this->assertEquals($this->id, $continent_by_id->id);
  }

  /** @test */
  public function it_is_retrievable_by_name()
  {
      $continent_by_name = app(Continent::class)->findByName($this->testContinent->name);

      $this->assertEquals($this->name, $continent_by_name->name);
  }

  /** @test */
  public function it_is_retrievable_by_iso3l()
  {
      $continent_by_iso3l = app(Continent::class)->findByIso($this->testContinent->iso3l);

      $this->assertEquals($this->iso3l, $continent_by_iso3l->iso3l);
  }
}
