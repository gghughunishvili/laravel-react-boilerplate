<?php

namespace App\Services\Traits;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Role;

trait RoleServiceTrait
{
    protected function getExistingRole(int $id): Role
    {
        $role = Role::find($id);

        if (!$role) {
            throw new ResourceNotFoundException("role not found.");
        }

        return $role;
    }
}
