<?php

namespace Papposilene\Geodata\Tests;

use Papposilene\Geodata\Models\Subcontinent;
use Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist;

class SubcontinentTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_when_a_subcontinent_does_not_exist()
    {
        $this->expectException(SubcontinentDoesNotExist::class);

        app(Subcontinent::class)->findByName('not a subcontinent');
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $subcontinent_by_id = app(Subcontinent::class)->findById($this->testSubcontinent->id);

        $this->assertEquals($this->testSubcontinent->id, $subcontinent_by_id->id);
    }

    /** @test */
    public function it_is_retrievable_by_name()
    {
        $subcontinent_by_name = app(Subcontinent::class)->findByName($this->testSubcontinent->name);

        $this->assertEquals($this->testSubcontinent->name, $subcontinent_by_name->name);
    }

    /** @test */
    public function it_is_retrievable_by_slug()
    {
        $subcontinent_by_slug = app(Subcontinent::class)->findBySlug($this->testSubcontinent->slug);

        $this->assertEquals($this->testSubcontinent->slug, $subcontinent_by_slug->slug);
    }
}
