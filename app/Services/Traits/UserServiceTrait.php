<?php

namespace App\Services\Traits;

use App\Exceptions\ForbiddenException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\User;

trait UserServiceTrait
{

    protected function getExistingUser(string $id): User
    {
        $user = User::find($id);

        if (!$user) {
            throw new ResourceNotFoundException("user not found.");
        }

        return $user;
    }

    protected function checkGettingPassiveUserPermission(User $user, User $actor)
    {
        if ($user->status == 'passive' && !$actor->may('get-passive-user')) {
            throw new ForbiddenException("You don't have permission to get passive user");
        }
    }

    protected function checkOwnerPermission(User $user, User $actor)
    {
        if ($user->id != $actor->id && !$actor->may('get-other-user')) {
            throw new ForbiddenException("No permission for this user.");
        }
    }

    protected function checkPermissionAndGetExistingUser(string $id, $actor = null): User
    {
        if (!$actor) {
            $actor = auth()->user();
        }

        $user = $this->getExistingUser($id);

        $this->checkOwnerPermission($user, $actor);
        $this->checkGettingPassiveUserPermission($user, $actor);

        return $user;
    }
}
