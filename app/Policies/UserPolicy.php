<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $actor, User $user)
    {
        if ($actor->hasPermission('update-any-user')) {
            return true;
        }

        if (!$actor->hasPermission('update-user')) {
            return false;
        }

        return $actor->id === $user->id;
    }

    public function get(User $actor, User $user)
    {
        if ($actor->hasPermission('get-any-user')) {
            return true;
        }

        if (!$actor->hasPermission('get-user')) {
            return false;
        }

        return $actor->id === $user->id;
    }
}
