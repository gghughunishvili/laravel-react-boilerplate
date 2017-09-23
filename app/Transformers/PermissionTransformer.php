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
            'display_name' => (string) $permission->display_name,
            'description' => (string) $permission->description,
        ];

        return $data;
    }
}
