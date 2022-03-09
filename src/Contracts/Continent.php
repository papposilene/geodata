<?php

namespace Papposilene\Geodata\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface Continent
{
    /**
     * A continent has many subcontinents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasSubcontinents(): HasMany;

    /**
     * A continent has many countries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasCountries(): HasMany;

    /**
     * Find or create a continent by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\ContinentDoesNotExist
     *
     * @return Geodata
     */
    public static function findOrCreate(string $name): self;

    /**
     * Find a continent by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\ContinentDoesNotExist
     *
     * @return Geodata
     */
    public static function findByName(string $name): self;

    /**
     * Find a continent by its id.
     *
     * @param int $id
     *
     * @throws \Papposilene\Geodata\Exceptions\ContinentDoesNotExist
     *
     * @return Geodata
     */
    public static function findById(int $id): self;
}
