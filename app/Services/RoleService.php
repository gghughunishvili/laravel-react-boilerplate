<?php

namespace App\Services;

use App\Exceptions\GeneralException;
use App\Models\Role;
use Symfony\Component\HttpFoundation\ParameterBag;

class RoleService extends AppService
{
    /**
     * Create a new role.
     *
     * @param  ParameterBag $params
     * @return Role
     */
    public function create(ParameterBag $params)
    {
        $role = new Role();

        $role->fill($params->all());
        $role->id = $this->getUuid();
        $role->save();

        return $role;
    }

    /**
     * Update the role.
     * @param  string $id
     * @param  ParameterBag $params
     * @return Role
     */
    public function update(string $id, ParameterBag $params)
    {
        $role = $this->checkingForExistingRole($id);

        if ($params->has('display_name')) {
            $role->display_name = $params->get('display_name');
        }

        if ($params->has('description')) {
            $role->description = $params->get('description');
        }

        $role->save();

        return $role;
    }

    /**
     * Get the specific role.
     *
     * @param  string $id
     * @return Role
     */
    public function get(string $id)
    {
        $role = $this->checkingForExistingRole($id);

        return $role;
    }

    /**
     * Find in roles.
     *
     * @param  string $id
     * @return Role
     */
    public function find(ParameterBag $filter)
    {
        $query = Role::query();

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
     * Delete the specific role.
     *
     * @param  string $id
     */
    public function delete(string $id)
    {
        $role = $this->checkingForExistingRole($id);

        $role->delete();
    }

    public function attachPermission(string $role_id, string $permission_id)
    {
        $role = $this->checkingForExistingRole($role_id);
        $permission = $this->checkingForExistingPermission($permission_id);

        if ($role->hasPermission($permission->name)) {
            throw new GeneralException("The permission is already attached to the role");
        }

        $role->attachPermission($permission);

        return $role;
    }

    public function detachPermission(string $role_id, string $permission_id)
    {
        $role = $this->checkingForExistingRole($role_id);
        $permission = $this->checkingForExistingPermission($permission_id);

        if (!$role->hasPermission($permission->name)) {
            throw new GeneralException("The permission isn't attached to the role");
        }

        $role->perms()->detach($permission);

        return $role;
    }
}
