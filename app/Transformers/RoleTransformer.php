<?php

namespace App\Transformers;

use App\Models\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];
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
}
