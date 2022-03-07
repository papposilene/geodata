<?php

namespace Papposilene\Geodata;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Papposilene\Geodata\Contracts\Continent as ContinentContract;
use Papposilene\Geodata\Contracts\Subcontinent as SubcontinentContract;
use Papposilene\Geodata\Contracts\Country as CountryContract;
use Papposilene\Geodata\Contracts\Currency as CurrencyContract;

class GeodataServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'geodata-migrations');

        $this->publishes([
            __DIR__ . '/../database/seeders/' => database_path('seeders'),
        ], 'geodata-seeders');

        $this->publishes([
            __DIR__ . '/../data/' => storage_path('data'),
        ], 'geodata-data');
    }

}
