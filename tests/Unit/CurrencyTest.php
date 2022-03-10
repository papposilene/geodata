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
    public function it_is_retrievable_by_id()
    {
        $currency_by_id = app(Currency::class)->findById($this->testCurrency->id);

        $this->assertEquals($this->testCurrency->id, $currency_by_id->id);
    }

    /** @test */
    public function it_is_retrievable_by_iso3l()
    {
        $currency_by_iso3l = app(Currency::class)->findByIso3l($this->testCurrency->iso3l);

        $this->assertEquals($this->testCurrency->iso3l, $currency_by_iso3l->iso3l);
    }

    /** @test */
    public function it_is_retrievable_by_iso3n()
    {
        $currency_by_iso3n = app(Currency::class)->findByIso3n($this->testCurrency->iso3n);

        $this->assertEquals($this->testCurrency->iso3n, $currency_by_iso3n->iso3n);
    }

    /** @test */
    public function it_is_retrievable_by_name()
    {
        $currency_by_name = app(Currency::class)->findByName($this->testCurrency->name);

        $this->assertEquals($this->testCurrency->name, $currency_by_name->name);
    }
}
