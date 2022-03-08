<?php

namespace Papposilene\Geodata\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Currency
{
    /**
     * A currency can be used in many countries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function belongsToCountries(): belongsToMany;

    /**
     * Find a currency by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return Geodata
     */
    public static function findByName(string $name): self;

    /**
     * Find a currency by its id.
     *
     * @param int $id
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return Geodata
     */
    public static function findById(int $id): self;

    /**
     * Find a currency by its iso code.
     *
     * @param string $iso
     *
     * @throws \Papposilene\Geodata\Exceptions\CurrencyDoesNotExist
     *
     * @return Geodata
     */
    public static function findByIso(string $iso): self;
}
