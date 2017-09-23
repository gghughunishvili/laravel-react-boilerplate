<?php

namespace App\Transformers;

use App\Models\User;
use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['roles', 'permissions'];
    protected $defaultIncludes = [];

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        $data = [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'status' => (string) $user->status,
        ];

        return $data;
    }

    public function includeRoles(User $user)
    {
        $roles = $user->roles;
        
        if (is_null($roles)) {
            return null;
        }
        
        return $this->collection($roles, new RoleTransformer(), 'role');
    }

    public function includePermissions(User $user)
    {
        $roles = $user->roles;
        
        if (is_null($roles)) {
            return null;
        }
        
        $permissions = collect([]);
        foreach ($roles as $role) {
            $permissions = $permissions->merge($role->perms);
        }
        $permissions = $permissions->unique('id');
        return $this->collection($permissions, new PermissionTransformer(), 'permission');
    }
}
