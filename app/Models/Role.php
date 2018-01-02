<?php

namespace App\Models;

use App\Exceptions\InvalidArgumentException;
use App\Models\Permission;
use App\Traits\ModelTrait;
use Spatie\Permission\Models\Role as ParentSpatieRole;

class Role extends ParentSpatieRole
{
    use ModelTrait;

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

    public function hasPermission(Permission $permission)
    {
        return $this->hasPermissionTo($permission);
    }

    public function givePermission(Permission $permission)
    {
        if ($this->hasPermission($permission)) {
            throw new InvalidArgumentException("The role already has this permission");
        }

        return $this->givePermissionTo($permission);
    }

    public function revokePermission(Permission $permission)
    {
        if (!$this->hasPermission($permission)) {
            throw new InvalidArgumentException("The role " . $this->name . " doesn't have permission to " . $permission->name);
        }

        return $this->revokePermissionTo($permission);
    }
}
