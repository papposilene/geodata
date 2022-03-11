<?php

namespace Papposilene\Geodata;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
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
            __DIR__ . '/../config/geodata.php',
            'geodata'
        );
    }

    protected function offerPublishing()
    {
        if (!function_exists('config_path')) {
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
    }

    protected function registerModelBindings()
    {
        $cfgOptions = $this->app->config['geodata.options'];
        $cfgModels = $this->app->config['geodata.models'];

        if (!$cfgOptions) {
            return;
        }

        $this->app->bind(Continent::class, $cfgModels['continents']);
        $this->app->bind(Subcontinent::class, $cfgModels['subcontinents']);
        $this->app->bind(Country::class, $cfgModels['countries']);

        if ($cfgOptions['currencies']) {
            $this->app->bind(
                \Papposilene\Geodata\Models\Currency::class,
                $cfgModels['currencies']
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
            ->push($this->app->databasePath() . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . $timestamp . '_' . $migrationFileName)
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
            ->push($this->app->databasePath() . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . $seederFileName)
            ->first();
    }
}
