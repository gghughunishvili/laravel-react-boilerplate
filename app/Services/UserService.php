<?php

namespace App\Services;

use App\Exceptions\GeneralException;
use App\Models\User;
use App\Services\Traits\UserServiceTrait;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserService extends AppService
{
    use UserServiceTrait;
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
        $user = $this->checkPermissionAndGetExistingUser($id);

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
        $user = $this->checkPermissionAndGetExistingUser($id);

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
        $user = $this->checkPermissionAndGetExistingUser($id);

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
}
