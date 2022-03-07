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

    /** @var string */
    protected $subcontinentClass;

    /** @var string */
    protected $countryClass;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $continents;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $subcontinents;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $coutries;

    /**
     * GeodataRegistrar constructor.
     */
    public function __construct()
    {

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

    public function getContinentClass($continentClass)
    {
        $this->continentClass = $continentClass;
        app()->bind(Continent::class, $continentClass);

        return $this;
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

    public function getSubcontinentClass($subcontinentClass)
    {
        $this->subcontinentClass = $subcontinentClass;
        app()->bind(Subcontinent::class, $subcontinentClass);

        return $this;
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

    public function getCountryClass($countryClass)
    {
        $this->countryClass = $countryClass;
        app()->bind(Country::class, $countryClass);

        return $this;
    }
}
