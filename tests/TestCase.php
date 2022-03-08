<?php

namespace Papposilene\Geodata\Test;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Papposilene\Geodata\Contracts\Continent;
use Papposilene\Geodata\Contracts\Subcontinent;
use Papposilene\Geodata\GeodataRegistrar;
use Papposilene\Geodata\GeodataServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('geodata.testing', true); //fix sqlite
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('geodata__continents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code');
            $table->string('slug');
            $table->string('name');
            $table->string('region');
            $table->json('translations');
        });

        $app['db']->connection()->getSchemaBuilder()->create('geodata__subcontinents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code');
            $table->string('name');
            $table->string('slug');
            $table->json('translations');
            $table->foreignId('continent_id')->constrained('geodata__continents');
        });

        $app['db']->connection()->getSchemaBuilder()->create('geodata__countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('continent_id')->constrained('geodata__continents');
            $table->foreignId('subcontinent_id')->constrained('geodata__subcontinents');
            $table->string('cca2');
            $table->string('cca3');
            $table->string('ccn3')->nullable();
            $table->string('cioc')->nullable();
            $table->string('name_eng_common');
            $table->string('name_eng_formal');
            $table->point('lat')->nullable();
            $table->point('lon')->nullable();
            $table->boolean('landlocked')->default(false);
            $table->json('neighbourhood')->nullable();
            $table->string('status')->nullable();
            $table->boolean('independent')->default(true);
            $table->boolean('un_member')->default(true);
            $table->string('flag')->nullable();
            $table->json('capital')->nullable();
            $table->json('currencies')->nullable();
            $table->json('demonyms')->nullable();
            $table->json('dialling_codes')->nullable();
            $table->json('languages')->nullable();
            $table->json('name_native')->nullable();
            $table->json('name_translations')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['cca2', 'cca3', 'name_eng_common', 'name_eng_formal']);
        });

        $app['db']->connection()->getSchemaBuilder()->create('geodata__currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('iso3l', 3);
            $table->integer('iso3n', 3);
            $table->string('type', 255);
            $table->json('units');
            $table->json('coins');
            $table->json('bills');

            $table->unique(['name', 'iso3l', 'iso3n']);
        });

        include_once __DIR__.'/../database/migrations/create_continents_tables.php.stub';
        include_once __DIR__.'/../database/migrations/create_subcontinents_tables.php.stub';
        include_once __DIR__.'/../database/migrations/create_countries_tables.php.stub';
        include_once __DIR__.'/../database/migrations/create_currencies_tables.php.stub';

        (new \CreateContinentsTables())->up();
        (new \CreateSubcontinentsTables())->up();
        (new \CreateCountriesTables())->up();
        (new \CreateCurrenciesTables())->up();

        $this->testContinent = Continent::create([
            'name' => 'Europe', 
            'slug' => 'europe', 
            'region' => 'EMEA',
            'translations' => [
                'fra' => 'Europe',
                'ita' => 'Europa',
                'chn' => '歐洲',
                'jap' => 'ヨーロッパ',
            ]
        ]);
        $this->testSubcontinent = Subcontinent::create([
            'code' => 155,
            'name' => 'Western Europe',
            'slug' => 'western-europe',
            'translations' => '',
            'continent_id' => $this->testContinent->id,
        ]);
        $this->testCountry = Country::create([
            'name' => 'France'
        ]);
        $this->testCurrency = Currency::create([
            'name' => 'Euro',
            'iso3l' => 'EUR',
            'iso3n' => '978',
            'type' => 'currency',
            'units' => [
                "major" => [
                    "name" => "euro",
                    "symbol" => "\u20ac"
                ],
                "minor" => [
                    "majorValue" => 0.01,
                    "name" => "cent",
                    "symbol" => "c"
                ],
            ],
            'coins' => [
                "frequent" => [
                    "\u20ac1",
                    "\u20ac2",
                    "5c",
                    "10c",
                    "20c",
                    "50c"
                ],
                "rare" => [
                    "1c",
                    "2c"
                ],
            ],
            'bills' => [
                "frequent" => [
                    "\u20ac5",
                    "\u20ac10",
                    "\u20ac20",
                    "\u20ac50",
                    "\u20ac100"
                ],
                "rare" => [
                    "\u20ac200",
                    "\u20ac500"
                ],
            ],
        ]);
    }

}
