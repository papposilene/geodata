<?php

namespace Papposilene\Geodata\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface Country
{
    /**
     * A country belongs to one subcontinent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToContinent(): BelongsTo;

    /**
     * A country belongs to one subcontinent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToSubcontinent(): BelongsTo;

    /**
     * Find a country by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\CountryDoesNotExist
     *
     * @return Geodata
     */
    public static function findByName(string $name): self;

    /**
     * Find a country by its id.
     *
     * @param int $id
     *
     * @throws \Papposilene\Geodata\Exceptions\CountryDoesNotExist
     *
     * @return Geodata
     */
    public static function findById(int $id): self;

    /**
     * Find a country by its CCA2 ISO code.
     *
     * @param string $cca2
     *
     * @throws \Papposilene\Geodata\Exceptions\CountryDoesNotExist
     *
     * @return Geodata
     */
    public static function findByCca2(string $id): self;

    /**
     * Find a country by its CCA3 ISO code.
     *
     * @param string $cca3
     *
     * @throws \Papposilene\Geodata\Exceptions\CountryDoesNotExist
     *
     * @return Geodata
     */
    public static function findByCca3(string $cca3): self;
}
