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
use Papposilene\Geodata\Models\Continent;
use Papposilene\Geodata\Models\Subcontinent;
use Papposilene\Geodata\Models\Country;

class GeodataServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->offerPublishing();

        $this->registerModelBindings();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/geodata.php',
            'geodata'
        );
    }

    protected function offerPublishing()
    {
        if (! function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        $config = $this->app->config['geodata.options'];

        $this->publishes([
            __DIR__ . '/../config/geodata.php' => config_path('geodata.php'),
        ], 'geodata-config');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_continents_tables.php.stub' => $this->getMigrationFileName('create_continents_tables.php'),
            __DIR__ . '/../database/migrations/create_subcontinents_tables.php.stub' => $this->getMigrationFileName('create_subcontinents_tables.php'),
            __DIR__ . '/../database/migrations/create_countries_tables.php.stub' => $this->getMigrationFileName('create_countries_tables.php'),
        ], 'geodata-migrations');

        $this->publishes([
            __DIR__ . '/../database/seeders/CountriesSeeder.php.stub' => $this->getSeederFileName('CountriesSeeder.php'),
        ], 'geodata-seeders');

        $this->publishes([
            __DIR__ . '/../data/countries/default/_all_countries.json' => storage_path('data/geodata/countries/countries.json'),
        ], 'geodata-data');

        if ($config['flags']) {
            $this->publishes([
                __DIR__ . '/../data/flags/' => public_path('svg/geodata-flags/'),
            ], 'geodata-flags');
        }

        if ($config['currencies']) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_currencies_tables.php.stub' => $this->getMigrationFileName('create_currencies_tables.php'),
                __DIR__ . '/../database/seeders/CurrenciesSeeder.php.stub' => $this->getSeederFileName('CurrenciesSeeder.php'),
                __DIR__ . '/../data/currencies/' => storage_path('data/geodata/currencies/'),
            ], 'geodata-currencies');
        }

        if ($config['geometries']) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_geometries_tables.php.stub' => $this->getMigrationFileName('create_geometries_tables.php'),
                __DIR__ . '/../database/seeders/GeometriesSeeder.php.stub' => $this->getSeederFileName('GeometriesSeeder.php'),
                __DIR__ . '/../data/geometries/' => storage_path('data/geodata/geometries/'),
            ], 'geodata-geometries');
        }

        if ($config['topologies']) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_topologies_tables.php.stub' => $this->getMigrationFileName('create_topologies_tables.php'),
                __DIR__ . '/../database/seeders/TopologiesSeeder.php.stub' => $this->getSeederFileName('TopologiesSeeder.php'),
                __DIR__ . '/../data/currencies/' => storage_path('data/geodata/currencies/'),
            ], 'geodata-topologies');
        }
    }

    protected function registerModelBindings()
    {
        $cfgOptions = $this->app->config['geodata.options'];
        $cfgModels = $this->app->config['geodata.models'];

        if (! $config) {
            return;
        }

        $this->app->bind(ContinentContract::class, $cfgModels['continents']);
        $this->app->bind(SubcontinentContract::class, $cfgModels['subcontinents']);
        $this->app->bind(CountryContract::class, $cfgModels['countries']);

        if ($cfgOptions['currencies']) {
            $this->app->bind(
                \\Papposilene\Geodata\Models\CurrencyContract::class, 
                $cfgModels['currencies']
            );
        }

        if ($cfgOptions['geometries']) {
            $this->app->bind(
                \\Papposilene\Geodata\Models\GeometryContract::class, 
                $cfgModels['geometries']
            );
        }

        if ($cfgOptions['topologies']) {
            $this->app->bind(
                \\Papposilene\Geodata\Models\TopologyContract::class, 
                $cfgModels['topologies']
            );
        }

    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @return string
     */
    protected function getMigrationFileName($migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path . '*_' . $migrationFileName);
            })
            ->push($this->app->databasePath() . '/migrations/' . $timestamp . '_' . $migrationFileName)
            ->first();
    }

    /**
     * Returns existing seeder file if found, else uses the current timestamp.
     *
     * @return string
     */
    protected function getSeederFileName($seederFileName): string
    {
        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $seederFileName) {
                return $filesystem->glob($path . $seederFileName);
            })
            ->push($this->app->databasePath() . '/seeders/' . $seederFileName)
            ->first();
    }

}
