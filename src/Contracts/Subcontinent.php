<?php

namespace Papposilene\Geodata\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface Subcontinent
{
    /**
     * A subcontinent belongs to one continent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToContinent(): BelongsTo;

    /**
     * A subcontinent has many countries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasCountries(): HasMany;

    /**
     * Find a subcontinent by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist
     *
     * @return Geodata
     */
    public static function findByName(string $name): self;

    /**
     * Find a subcontinent by its id.
     *
     * @param int $id
     *
     * @throws \Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist
     *
     * @return Geodata
     */
    public static function findById(int $id): self;
}
