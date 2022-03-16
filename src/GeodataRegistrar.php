<?php

namespace Papposilene\Geodata;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Papposilene\Geodata\Models\Continent;
use Papposilene\Geodata\Models\Subcontinent;
use Papposilene\Geodata\Models\Country;
use Papposilene\Geodata\Models\City;

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
        $this->continents = Continent::all();

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
        $this->subcontinents = Subcontinent::all();

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
        $this->countries = Countries::all();

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
     * Get the cities based on the passed params.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCities(array $params = [], bool $onlyOne = false): Collection
    {
        $this->cities = City::all();

        $method = $onlyOne ? 'first' : 'filter';

        $cities = $this->cities->$method(static function ($city) use ($params) {
            foreach ($params as $attr => $value) {
                if (!Str::contains($city->getAttribute($attr), $value)) {
                    return false;
                }
            }

            return true;
        });

        if ($onlyOne) {
            $cities = new Collection($cities ? [$cities] : []);
        }

        return $cities;
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

}
