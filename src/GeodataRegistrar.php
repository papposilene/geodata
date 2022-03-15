<?php

namespace Papposilene\Geodata;

use Illuminate\Database\Eloquent\Collection;
use Papposilene\Geodata\Models\Continent;
use Papposilene\Geodata\Models\Subcontinent;
use Papposilene\Geodata\Models\Country;
use Papposilene\Geodata\Models\City;
use Papposilene\Geodata\Models\Currency;

class GeodataRegistrar
{
    /** @var string */
    protected $continentClass;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $continents;

    /** @var string */
    protected $subcontinentClass;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $subcontinents;

    /** @var string */
    protected $countryClass;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $countries;

    /** @var string */
    protected $cityClass;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $cities;

    /** @var string */
    protected $currencyClass;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $currencies;

    /**
     * GeodataRegistrar constructor.
     */
    public function __construct()
    {
        // Mandatory models
        $this->continentClass = config('geodata.models.continents');
        $this->subcontinentClass = config('geodata.models.subcontinents');
        $this->countryClass = config('geodata.models.countries');
        $this->cityClass = config('geodata.models.cities');
        $this->currencyClass = config('geodata.models.currencies');
    }

    /**
     * Get the continents based on the passed params.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContinents(array $params = [], bool $onlyOne = false): Collection
    {
        $method = $onlyOne ? 'first' : 'filter';

        $continents = $this->continents->$method(static function ($continent) use ($params) {
            foreach ($params as $attr => $value) {
                if ($continent->getAttribute($attr) != $value) {
                    return false;
                }
            }

            return true;
        });

        if ($onlyOne) {
            $continents = new Collection($continents ? [$continents] : []);
        }

        return $continents;
    }

    /**
     * Get an instance of the continent class.
     *
     * @return \Papposilene\Geodata\Models\Continent
     */
    public function getContinentClass(): Continent
    {
        return app($this->continentClass);
    }

    public function setContinentClass($continentClass)
    {
        $this->continentClass = $continentClass;
        config()->set('geodata.models.continents', $continentClass);
        app()->bind(Continent::class, $continentClass);

        return $this;
    }

    /**
     * Get the subcontinents based on the passed params.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubcontinents(array $params = [], bool $onlyOne = false): Collection
    {
        $method = $onlyOne ? 'first' : 'filter';

        $subcontinents = $this->subcontinents->$method(static function ($subcontinent) use ($params) {
            foreach ($params as $attr => $value) {
                if ($subcontinent->getAttribute($attr) != $value) {
                    return false;
                }
            }

            return true;
        });

        if ($onlyOne) {
            $subcontinents = new Collection($subcontinents ? [$subcontinents] : []);
        }

        return $subcontinents;
    }

    /**
     * Get an instance of the subcontinent class.
     *
     * @return \Papposilene\Geodata\Models\Subcontinent
     */
    public function getSubcontinentClass(): Subcontinent
    {
        return app($this->subcontinentClass);
    }

    public function setSubcontinentClass($subcontinentClass)
    {
        $this->subcontinentClass = $subcontinentClass;
        config()->set('geodata.models.subcontinents', $subcontinentClass);
        app()->bind(Subcontinent::class, $subcontinentClass);

        return $this;
    }

    /**
     * Get the countries based on the passed params.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCountries(array $params = [], bool $onlyOne = false): Collection
    {
        $method = $onlyOne ? 'first' : 'filter';

        $countries = $this->countries->$method(static function ($country) use ($params) {
            foreach ($params as $attr => $value) {
                if ($country->getAttribute($attr) != $value) {
                    return false;
                }
            }

            return true;
        });

        if ($onlyOne) {
            $countries = new Collection($countries ? [$countries] : []);
        }

        return $countries;
    }

    /**
     * Get an instance of the country class.
     *
     * @return \Papposilene\Geodata\Models\Country
     */
    public function getCountryClass(): Country
    {
        return app($this->countryClass);
    }

    public function setCountryClass($countryClass)
    {
        $this->countryClass = $countryClass;
        config()->set('geodata.models.countries', $countryClass);
        app()->bind(Country::class, $countryClass);

        return $this;
    }

    /**
     * Get the currencies based on the passed params.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCurrencies(array $params = [], bool $onlyOne = false): Collection
    {
        $method = $onlyOne ? 'first' : 'filter';

        $currencies = $this->currencies->$method(static function ($currency) use ($params) {
            foreach ($params as $attr => $value) {
                if ($currency->getAttribute($attr) != $value) {
                    return false;
                }
            }

            return true;
        });

        if ($onlyOne) {
            $currencies = new Collection($currencies ? [$currencies] : []);
        }

        return $currencies;
    }

    /**
     * Get an instance of the city class.
     *
     * @return \Papposilene\Geodata\Models\City
     */
    public function getCityClass(): City
    {
        return app($this->cityClass);
    }

    public function setCityClass($cityClass)
    {
        $this->cityClass = $cityClass;
        config()->set('geodata.models.cities', $cityClass);
        app()->bind(City::class, $cityClass);

        return $this;
    }

    /**
     * Get an instance of the currency class.
     *
     * @return \Papposilene\Geodata\Models\Currency
     */
    public function getCurrencyClass(): Currency
    {
        return app($this->currencyClass);
    }

    public function setCurrencyClass($currencyClass)
    {
        $this->currencyClass = $currencyClass;
        config()->set('geodata.models.currencies', $currencyClass);
        app()->bind(Currency::class, $currencyClass);

        return $this;
    }

}
