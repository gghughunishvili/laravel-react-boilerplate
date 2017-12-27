<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ParentSpatieRole;

class Role extends ParentSpatieRole
{
    /**
     * Get a role by its name.
     * Where findByName throws exception
     * @param string $name
     *
     * @return Role or null
     */
    public static function getByName($name)
    {
        $role = static::where('name', $name)->first();

        return $role;
    }
}
