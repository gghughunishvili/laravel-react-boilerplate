<?php

namespace App\Services;

use App\Models\Role;
use App\Services\Traits\RoleServiceTrait;
use App\Validators\Role\StoreValidator;
use Symfony\Component\HttpFoundation\ParameterBag;

class RoleService extends AppService
{
    use RoleServiceTrait;
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
     * @param  string $id
     * @return Role
     */
    public function get(string $id) : Role
    {
        $this->authUser->should('get-role');
        $role = $this->getExistingRole($id);

        return $role;
    }

    /**
     * Get all matched roles.
     *
     * @param  string $id
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
     * @param  string $id
     */
    public function delete(string $id)
    {
        $this->authUser->should('delete-role');

        $role = $this->getExistingRole($id);

        $role->delete();
    }
}
