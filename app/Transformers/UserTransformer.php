<?php

namespace App\Transformers;

use App\Models\User;
use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['roles'];
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
            'username' => (string) $user->username,
            'email' => (string) $user->email,
            'status' => (string) $user->status,
            'createdAt' => (string) $user->created_at,
            'updatedAt' => (string) $user->updated_at,
        ];

        return $data;
    }

    public function includeRoles(User $user)
    {
        return $this->collection($user->roles, new RoleTransformer(), 'Role');
    }
}
