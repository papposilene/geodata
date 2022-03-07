<?php

namespace Papposilene\Geodata\Test;

use DB;
use PHPUnit\Framework\TestCase;
use Papposilene\Geodata\Contracts\Continent;
use Papposilene\Geodata\Contracts\Subcontinent;
use Papposilene\Geodata\Exceptions\ContinentDoesNotExist;
use Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist;

class ContinentsTest extends TestCase
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
      $continent_by_id = app(Continent::class)->findById($this->id);

      $this->assertEquals($this->id, $continent_by_id->id);
  }
}
