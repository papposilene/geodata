<?php

namespace Papposilene\Geodata\Tests;

use Papposilene\Geodata\Models\Currency;
use Papposilene\Geodata\Exceptions\CurrencyDoesNotExist;

class CurrencyTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_when_a_currency_does_not_exist()
    {
        $this->expectException(CurrencyDoesNotExist::class);

        app(Currency::class)->findByName('not a currency');
    }

    /** @test */
    public function it_is_retrievable_by_code()
    {
        $currency_by_code = app(Currency::class)->findByCode($this->testCurrency->code);

        $this->assertEquals($this->testCurrency->code, $currency_by_code->code);
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $currency_by_id = app(Currency::class)->findById($this->testCurrency->id);

        $this->assertEquals($this->testCurrency->id, $currency_by_id->id);
    }

    /** @test */
    public function it_is_retrievable_by_name()
    {
        $currency_by_name = app(Currency::class)->findByName($this->testCurrency->name);

        $this->assertEquals($this->testCurrency->name, $currency_by_name->name);
    }

    /** @test */
    public function it_is_retrievable_by_slug()
    {
        $currency_by_slug = app(Currency::class)->findBySlug($this->testCurrency->slug);

        $this->assertEquals($this->testCurrency->slug, $currency_by_slug->slug);
    }
}
