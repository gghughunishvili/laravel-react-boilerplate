<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService extends AppService
{
    /**
     * Get all matched permissions.
     *
     * @param  string $id
     * @return collection Permission
     */
    public function find()
    {
        $this->authUser->should('find-permission');
        $permissions = Permission::all();
        return $permissions;
    }
}
