<?php

namespace App\Services;

use App\Exceptions\InvalidArgumentException;
use App\Models\Permission;
use App\Models\Role;
use App\Validators\Role\StoreValidator;
use Symfony\Component\HttpFoundation\ParameterBag;

class RoleService extends AppService
{
    /**
     * Create a new role
     *
     * @param  StoreValidator $validator
     * @return Role
     */
    public function create(StoreValidator $validator) : Role
    {
        $validator->validate();
        $params = $validator->getParamsBag();

        $this->authUser->should('create-role');

        $role = new Role;
        $role->name = $params->get('name');
        $role->save();

        return $role;
    }

    /**
     * Get a role instance.
     *
     * @param  int $id
     * @return Role
     */
    public function get(int $id) : Role
    {
        $this->authUser->should('get-role');
        $role = Role::getExistingModel($id);

        return $role;
    }

    /**
     * Get all matched roles.
     *
     * @param  int $id
     * @return Role
     */
    public function find()
    {
        $this->authUser->should('find-role');
        $roles = Role::all();
        return $roles;
    }

    /**
     * Delete specific role.
     *
     * @param  int $id
     */
    public function delete(int $id)
    {
        $this->authUser->should('delete-role');

        $role = Role::getExistingModel($id);

        $role->delete();
    }

    public function getPermissions(int $id)
    {
        $this->authUser->should('find-permissions-for-role');

        $role = Role::getExistingModel($id);

        return $role;
    }

    public function attachPermission(int $roleId, int $permissionId)
    {
        $this->authUser->should('attach-permission-to-role');

        $role = Role::getExistingModel($roleId);

        $permission = Permission::getExistingModel($permissionId);

        $role->givePermission($permission);

        return $role->fresh();
    }

    public function detachPermission(int $roleId, int $permissionId)
    {
        $this->authUser->should('detach-permission-from-role');

        $role = Role::getExistingModel($roleId);

        $permission = Permission::getExistingModel($permissionId);

        $role->revokePermission($permission);

        return $role->fresh();
    }
}
