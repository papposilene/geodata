<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Papposilene\Geodata\Contracts\Continent as ContinentContract;
use Papposilene\Geodata\Exceptions\ContinentDoesNotExist;
use Papposilene\Geodata\PermissionRegistrar;

class Continent extends Model implements ContinentContract
{
    use HasRoles;

    public function __construct() { }

    public function getTable()
    {
        return 'geodata__continents';
    }

    /**
     * A continent can have many subcontinents.
     */
    public function hasSubcontinents(): HasMany
    {
        return $this->hasMany(
            Subcontinent::class,
            'continent',
            'id'
        );
    }

    /**
     * Find a continent by its name.
     *
     * @param string $name
     *
     * @throws \Papposilene\Geodata\Exceptions\ContinentDoesNotExist
     *
     * @return \Papposilene\Geodata\Contracts\Continent
     */
    public static function findByName(string $name): ContinentContract
    {
        $continent = static::getContinent(['id' => $id]);

        if (! $continent) {
            throw ContinentDoesNotExist::withName($id);
        }

        return $continent;
    }

    /**
     * Find a continent by its id.
     *
     * @param int $id
     *
     * @throws \Papposilene\Geodata\Exceptions\PermissionDoesNotExist
     *
     * @return \Papposilene\Geodata\Contracts\Continent
     */
    public static function findById(int $id): ContinentContract
    {
        $continent = static::getContinent(['id' => $id]);

        if (! $continent) {
            throw ContinentDoesNotExist::withId($id);
        }

        return $continent;
    }

    /**
     * Find a continent by its name.
     *
     * @param string $name
     *
     * @return \Papposilene\Geodata\Contracts\Continent
     */
    public static function findOrCreate(string $name): ContinentContract
    {
        $continent = static::getContinent(['name' => $name]);

        if (! $continent) {
            throw ContinentDoesNotExist::withName($name);
        }

        return $continent;
    }

    /**
     * Get the current cached permissions.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function getPermissions(array $params = [], bool $onlyOne = false): Collection
    {
        return app(PermissionRegistrar::class)
            ->setPermissionClass(static::class)
            ->getPermissions($params, $onlyOne);
    }

    /**
     * Get the current cached first permission.
     *
     * @param array $params
     *
     * @return \Papposilene\Geodata\Contracts\Permission
     */
    protected static function getPermission(array $params = []): ?PermissionContract
    {
        return static::getPermissions($params, true)->first();
    }
}
