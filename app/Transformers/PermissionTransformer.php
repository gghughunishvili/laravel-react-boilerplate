<?php

namespace App\Transformers;

use App\Models\Permission;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = [];

    /**
     * @param Permission $permission
     * @return array
     */
    public function transform(Permission $permission)
    {
        $data = [
            'id' => (string) $permission->id,
            'name' => (string) $permission->name,
            'createdAt' => (string) $permission->created_at,
            'updatedAt' => (string) $permission->updated_at,
        ];

        return $data;
    }
}
