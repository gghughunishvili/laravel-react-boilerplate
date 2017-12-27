<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as ParentSpatiePermission;

class Permission extends ParentSpatiePermission
{
    /**
     * Get a permission by its name.
     * Where findByName throws exception
     * @param string $name
     *
     * @return Permission or null
     */
    public static function getByName($name)
    {
        $permission = static::where('name', $name)->first();

        return $permission;
    }
}
