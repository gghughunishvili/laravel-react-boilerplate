<?php

namespace App\Services;

use App\Exceptions\GeneralException;
use App\Models\User;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserService extends AppService
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  ParameterBag $params
     * @return User
     */
    public function create(ParameterBag $params)
    {
        $user = new User;
        $user->fill($params->all());
        $user->password = bcrypt($params->get('password'));
        $user->status = 'pending';
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
        $user = $this->checkingForExistingUser($id);

        if ($user->status == 'passive' && !auth()->user()->may('get-passive-user')) {
            throw new ForbiddenException("You don't have permission to get passive user");
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
        $users = User::all();
        if (!auth()->user()->may('get-passive-user')) {
            $users = $users->where('status', '<>' ,'passive')->get();
        }
        return $users;
    }

    /**
     * Uodate a user instance.
     *
     * @param  string $id,
     * @param  ParameterBag $params,
     * @return User
     */
    public function update(string $id, ParameterBag $params)
    {
        $user = $this->checkingForExistingUser($id);

        if ($params->has('name')) {
            $user->name = $params->get('name');
        }

        if ($params->has('status')) {
            $user->status = $params->get('status');
        }

        $user->save();

        return $user;
    }

    /**
     * Delete specific user.
     *
     * @param  string $id
     */
    public function delete(string $id)
    {
        $user = $this->checkingForExistingUser($id);

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

    public function attachRole(string $user_id, string $role_id)
    {
        $user = $this->checkingForExistingUser($user_id);
        $role = $this->checkingForExistingRole($role_id);

        if ($user->hasRole($role->name)) {
            throw new GeneralException("The role is already attached to the user");
        }

        $user->attachRole($role);

        return $user;
    }

    public function detachRole(string $user_id, string $role_id)
    {
        $user = $this->checkingForExistingUser($user_id);
        $role = $this->checkingForExistingRole($role_id);

        if (!$user->hasRole($role->name)) {
            throw new GeneralException("The role isn't attached to the user");
        }

        $user->roles()->detach($role);

        return $user;
    }
}
