<?php

namespace Papposilene\Geodata;

use Illuminate\Database\Eloquent\Collection;
use Papposilene\Geodata\Contracts\Continent;
use Papposilene\Geodata\Contracts\Subcontinent;
use Papposilene\Geodata\Contracts\Country;

class GeodatanRegistrar
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
    protected $currencyClass;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $currencies;

    /** @var string */
    protected $geometryClass;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $geometries;

    /** @var string */
    protected $topologyClass;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $topologies;

    /**
     * GeodataRegistrar constructor.
     */
    public function __construct()
    {
        // Mandatory models
        $this->continentClass = config('geodata.models.continents');
        $this->subcontinentClass = config('geodata.models.subcontinents');
        $this->countryClass = config('geodata.models.countries');

        // Optional models
        $this->currencyClass = config('geodata.models.currencies');
        $this->geometryClass = config('geodata.models.geometries');
        $this->topologyClass = config('geodata.models.topologies');
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
     * @return \Papposilene\Geodata\Contracts\Continent
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
     * @return \Papposilene\Geodata\Contracts\Subcontinent
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
     * @return \Papposilene\Geodata\Contracts\Country
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
     * Get an instance of the currency class.
     *
     * @return \Papposilene\Geodata\Contracts\Currency
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

    /**
     * Get the geometries based on the passed params.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getGeometries(array $params = [], bool $onlyOne = false): Collection
    {
        $method = $onlyOne ? 'first' : 'filter';

        $geometries = $this->geometries->$method(static function ($geometry) use ($params) {
            foreach ($params as $attr => $value) {
                if ($geometry->getAttribute($attr) != $value) {
                    return false;
                }
            }

            return true;
        });

        if ($onlyOne) {
            $geometries = new Collection($geometries ? [$geometries] : []);
        }

        return $geometries;
    }

    /**
     * Get an instance of the geometry class.
     *
     * @return \Papposilene\Geodata\Contracts\Geometry
     */
    public function getGeometryClass(): Geometry
    {
        return app($this->geometryClass);
    }

    public function setGeometryClass($geometryClass)
    {
        $this->geometryClass = $geometryClass;
        config()->set('geodata.models.geometries', $geometryClass);
        app()->bind(Geometry::class, $geometryClass);

        return $this;
    }

    /**
     * Get the topologies based on the passed params.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTopologies(array $params = [], bool $onlyOne = false): Collection
    {
        $method = $onlyOne ? 'first' : 'filter';

        $topologies = $this->topologies->$method(static function ($topology) use ($params) {
            foreach ($params as $attr => $value) {
                if ($topology->getAttribute($attr) != $value) {
                    return false;
                }
            }

            return true;
        });

        if ($onlyOne) {
            $topologies = new Collection($topologies ? [$topologies] : []);
        }

        return $topologies;
    }

    /**
     * Get an instance of the topology class.
     *
     * @return \Papposilene\Geodata\Contracts\Topology
     */
    public function getTopologyClass(): Topology
    {
        return app($this->topologyClass);
    }

    public function setTopologyClass($topologyClass)
    {
        $this->topologyClass = $topologyClass;
        config()->set('geodata.models.topologies', $topologyClass);
        app()->bind(Topology::class, $topologyClass);

        return $this;
    }
}
