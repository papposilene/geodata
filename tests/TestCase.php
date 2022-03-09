<?php

declare(strict_types=1);

namespace Papposilene\Geodata\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;
use Papposilene\Geodata\Contracts\Continent;
use Papposilene\Geodata\Contracts\Subcontinent;
use Papposilene\Geodata\Contracts\Country;
use Papposilene\Geodata\Contracts\Currency;
//use Papposilene\Geodata\Contracts\Geometry;
//use Papposilene\Geodata\Contracts\Topology;
use Papposilene\Geodata\GeodataRegistrar;
use Papposilene\Geodata\GeodataServiceProvider;

abstract class TestCase extends Orchestra
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            GeodataServiceProvider::class,
        ];
    }

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
            $table->integer('code', false);
            $table->string('slug');
            $table->string('name');
            $table->string('region');
            $table->json('translations');
        });

        $app['db']->connection()->getSchemaBuilder()->create('geodata__subcontinents', function (Blueprint $table) {
            $table->id();
            $table->integer('code', false);
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
            $table->integer('iso3n', false);
            $table->string('type', 255);
            $table->json('units');
            $table->json('coins');
            $table->json('bills');

            $table->unique(['name', 'iso3l', 'iso3n']);
        });

        include_once __DIR__ . '/../database/migrations/create_continents_tables.php.stub';
        include_once __DIR__ . '/../database/migrations/create_subcontinents_tables.php.stub';
        include_once __DIR__ . '/../database/migrations/create_countries_tables.php.stub';
        include_once __DIR__ . '/../database/migrations/create_currencies_tables.php.stub';

        (new \CreateContinentsTables())->up();
        (new \CreateSubcontinentsTables())->up();
        (new \CreateCountriesTables())->up();
        (new \CreateCurrenciesTables())->up();

        $this->testContinent = Continent::firstOrCreate([
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

        $this->testSubcontinent = Subcontinent::firstOrCreate([
            'code' => 155,
            'name' => 'Western Europe',
            'slug' => 'western-europe',
            'translations' => '',
            'continent_id' => $this->testContinent->id,
        ]);

        $this->testCountry = Country::firstOrCreate([
            'continent_id' => $this->testContinent->id,
            'subcontinent_id' => $this->testSubcontinent->id,
            'cca2' => 'FR',
            'cca3' => 'FRA',
            'ccn3' => 250,
            'cioc' => 'FRA',
            'name_eng_common' => 'France',
            'name_eng_formal' => 'French Republic',
            'lat' => 46.63727951049805,
            'lon' => 2.3382623195648193,
            'landlocked' => false,
            'neighbourhood' => [
                'AND',
                'BEL',
                'DEU',
                'ITA',
                'LUX',
                'MCO',
                'ESP',
                'CHE'
            ],
            'status' => 'officially-assigned',
            'independent' => true,
            'un_member' => true,
            'flag' => '\ud83c\uddeb\ud83c\uddf7',
            'capital' => ['Paris'],
            'currencies' => ['EUR'],
            'demonyms' => [
                'eng' => [
                    'f' => 'French',
                    'm' => 'French',
                ],
                'fra' => [
                    'f' => 'Fran\u00e7aise',
                    'm' => 'Fran\u00e7ais',
                ]
            ],
            'dialling_codes' => [
                'calling_code' => ['33'],
                'international_prefix' => '00',
                'national_destination_code_lengths' => [1],
                'national_number_lengths' => [9, 10],
                'national_prefix' => '0',
            ],
            'languages' => ['fra' => 'French'],
            'name_native' => [
                'fra' => [
                    'common' => 'France',
                    'official' => 'R\u00e9publique fran\u00e7aise'
                ]
            ],
            'name_translations' => [
                'ces' => [
                    'common' => 'Francie',
                    'official' => 'Francouzsk\u00e1 republika',
                ],
                'deu' => [
                    'common' => 'Frankreich',
                    'official' => 'Franz\u00f6sische Republik',
                ],
                'est' => [
                    'common' => 'Prantsusmaa',
                    'official' => 'Prantsuse Vabariik',
                ],
                'fin' => [
                    'common' => 'Ranska',
                    'official' => 'Ranskan tasavalta',
                ],
                'fra' => [
                    'common' => 'France',
                    'official' => 'R\u00e9publique fran\u00e7aise',
                ],
                'hrv' => [
                    'common' => 'Francuska',
                    'official' => 'Francuska Republika',
                ],
                'hun' => [
                    'common' => 'Franciaorsz\u00e1g',
                    'official' => 'Francia K\u00f6zt\u00e1rsas\u00e1g',
                ],
                'ita' => [
                    'common' => 'Francia',
                    'official' => 'Repubblica francese',
                ],
                'jpn' => [
                    'common' => '\u30d5\u30e9\u30f3\u30b9',
                    'official' => '\u30d5\u30e9\u30f3\u30b9\u5171\u548c\u56fd',
                ],
                'kor' => [
                    'common' => '\ud504\ub791\uc2a4',
                    'official' => '\ud504\ub791\uc2a4 \uacf5\ud654\uad6d',
                ],
                'nld' => [
                    'common' => 'Frankrijk',
                    'official' => 'Franse Republiek',
                ],
                'per' => [
                    'common' => '\u0641\u0631\u0627\u0646\u0633\u0647',
                    'official' => '\u062c\u0645\u0647\u0648\u0631\u06cc \u0641\u0631\u0627\u0646\u0633\u0647',
                ],
                'pol' => [
                    'common' => 'Francja',
                    'official' => 'Republika Francuska',
                ],
                'por' => [
                    'common' => 'Fran\u00e7a',
                    'official' => 'Rep\u00fablica Francesa',
                ],
                'rus' => [
                    'common' => '\u0424\u0440\u0430\u043d\u0446\u0438\u044f',
                    'official' => '\u0424\u0440\u0430\u043d\u0446\u0443\u0437\u0441\u043a\u0430\u044f \u0420\u0435\u0441\u043f\u0443\u0431\u043b\u0438\u043a\u0430',
                ],
                'slk' => [
                    'common' => 'Franc\u00fazsko',
                    'official' => 'Franc\u00fazska republika',
                ],
                'spa' => [
                    'common' => 'Francia',
                    'official' => 'Rep\u00fablica franc\u00e9s',
                ],
                'swe' => [
                    'common' => 'Frankrike',
                    'official' => 'Republiken Frankrike',
                ],
                'urd' => [
                    'common' => '\u0641\u0631\u0627\u0646\u0633',
                    'official' => '\u062c\u0645\u06c1\u0648\u0631\u06cc\u06c1 \u0641\u0631\u0627\u0646\u0633',
                ],
                'zho' => [
                    'common' => '\u6cd5\u56fd',
                    'official' => '\u6cd5\u5170\u897f\u5171\u548c\u56fd',
                ]
            ],
            'extra' => [
                'address_format' => '{{recipient}}{{street}}{{postalcode}} {{city}}{{country}}',
                'wikidata' => 'Q142',
                'woe_id_eh' => 23424819,
            ],
        ]);

        $this->testCurrency = Currency::firstOrCreate([
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
