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
    public function inSubcontinent(): BelongsTo;

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
}
