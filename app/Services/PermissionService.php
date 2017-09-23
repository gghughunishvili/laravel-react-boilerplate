<?php

namespace App\Services;

use App\Models\Permission;
use Symfony\Component\HttpFoundation\ParameterBag;

class PermissionService extends AppService
{
    /**
     * Create a new permission.
     *
     * @param  ParameterBag $params
     * @return Permission
     */
    public function create(ParameterBag $params)
    {
        $permission = new Permission();

        $permission->fill($params->all());
        $permission->id = $this->getUuid();
        $permission->save();

        return $permission;
    }

    /**
     * Update the permission.
     * @param  string $id
     * @param  ParameterBag $params
     * @return Permission
     */
    public function update(string $id, ParameterBag $params)
    {
        $permission = $this->checkingForExistingPermission($id);

        if ($params->has('display_name')) {
            $permission->display_name = $params->get('display_name');
        }

        if ($params->has('description')) {
            $permission->description = $params->get('description');
        }

        $permission->save();

        return $permission;
    }

    /**
     * Get the specific permission.
     *
     * @param  string $id
     * @return Permission
     */
    public function get(string $id)
    {
        $permission = $this->checkingForExistingPermission($id);

        return $permission;
    }

    /**
     * Find in permissions.
     *
     * @param  string $id
     * @return Collection of Permissions
     */
    public function find(ParameterBag $filter)
    {
        $query = Permission::query();

        if ($filter->has('id')) {
            $query->where('id', $filter->get('id'));
        }

        if ($filter->has('name')) {
            $query->where('name', 'like', '%' . $filter->get('name') . '%');
        }

        if ($filter->has('display_name')) {
            $query->where('display_name', 'like', '%' . $filter->get('display_name') . '%');
        }

        if ($filter->has('description')) {
            $query->where('description', 'like', '%' . $filter->get('description') . '%');
        }

        if ($filter->getInt('limit')) {
            $query->withoutGlobalScope('limit')->limit($filter->getInt('limit'));
        }
        if ($filter->getInt('offset')) {
            $query->offset($filter->getInt('offset'));
        }

        return $query->get();
    }

    /**
     * Delete the specific permission.
     *
     * @param  string $id
     */
    public function delete(string $id)
    {
        $permission = $this->checkingForExistingPermission($id);

        $permission->delete();
    }
}
