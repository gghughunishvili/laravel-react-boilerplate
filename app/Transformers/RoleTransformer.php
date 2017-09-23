<?php

namespace App\Transformers;

use App\Models\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    
    protected $availableIncludes = ['permissions'];
    
    protected $defaultIncludes = [];

    /**
     * @param Role $role
     * @return array
     */
    public function transform(Role $role)
    {
        $data = [
            'id' => (string) $role->id,
            'name' => (string) $role->name,
            'display_name' => (string) $role->display_name,
            'description' => (string) $role->description,
        ];

        return $data;
    }

    public function includePermissions(Role $role)
    {
        $permissions = $role->perms;
        return $this->collection($permissions, new PermissionTransformer(), 'permission');
    }
}
