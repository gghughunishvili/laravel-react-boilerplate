<?php

namespace App\Transformers;

use App\Models\Role;
use App\Transformers\PermissionTransformer;
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
            'createdAt' => (string) $role->created_at,
            'updatedAt' => (string) $role->updated_at,
        ];

        return $data;
    }

    public function includePermissions(Role $role)
    {
        return $this->collection($role->permissions, new PermissionTransformer(), 'Permission');
    }
}
