<?php

namespace App\Services;

use App\Exceptions\ForbiddenException;
use App\Exceptions\GeneralException;
use App\Exceptions\InvalidArgumentException;
use App\Models\Role;
use App\Models\User;
use App\Services\Traits\UserServiceTrait;
use App\Validators\User\CreateValidator;
use App\Validators\User\UpdateValidator;
use Bouncer;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserService extends AppService
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  CreateValidator $validator
     * @return User
     */
    public function create(CreateValidator $validator) : User
    {
        $validator->validate();
        $params = $validator->getParamsBag();

        $user = new User;
        $user->fill($params->all());
        $user->status = config('custom.user.status.pending');
        $user->save();
        return $user;
    }

    /**
     * Get a user instance.
     *
     * @param  string $id
     * @return User
     */
    public function get(string $id)
    {
        $user = User::GetExistingModel($id);

        if ($this->authUser->cant('get', $user)) {
            throw new ForbiddenException("No permission to get this user");
        }

        return $user;
    }

    /**
     * Get all matched users.
     *
     * @param  string $id
     * @return User
     */
    public function find()
    {
        $this->authUser->should('find-user');

        $users = User::all();
        return $users;
    }

    /**
     * Uodate a user instance.
     *
     * @param  string $id,
     * @param  ParameterBag $params,
     * @return User
     */
    public function update(string $id, UpdateValidator $validator)
    {
        $params = $validator->getParamsBag();
        $user = User::GetExistingModel($id);

        if ($this->authUser->cant('update', $user)) {
            throw new ForbiddenException("No permission to get this user");
        }

        if ($params->has('name')) {
            $user->name = $params->get('name');
        }

        if ($params->has('status')) {
            $this->authUser->should('update-status-of-user');
            $user->status = $params->get('status');
        }

        $user->save();

        return $user->fresh();
    }

    /**
     * Delete specific user.
     *
     * @param  string $id
     */
    public function delete(string $id)
    {
        $this->authUser->should('delete-user');
        $user = User::GetExistingModel($id);

        $user->delete();
    }

    /**
     * Get authorized user
     * @return User
     */
    public function authorizedUser()
    {
        return auth()->user();
    }

    public function findRoles(string $id) : User
    {
        $this->authUser->should('find-roles-for-user');

        $user = User::getExistingModel($id);

        return $user;
    }

    public function attachRole(string $userId, int $roleId) : User
    {
        $this->authUser->should('attach-role-to-user');

        $user = User::getExistingModel($userId);

        $role = Role::getExistingModel($roleId);

        if ($user->hasRole($role)) {
            throw new InvalidArgumentException("The role is already assigned to the user");
        }

        $user->assignRole($role);

        return $user->fresh();
    }

    public function detachRole(string $userId, int $roleId) : User
    {
        $this->authUser->should('detach-role-from-user');

        $user = User::getExistingModel($userId);

        $role = Role::getExistingModel($roleId);

        if (!$user->hasRole($role)) {
            throw new InvalidArgumentException("The role is not assigned to the user");
        }

        $user->removeRole($role);

        return $user->fresh();
    }
}
