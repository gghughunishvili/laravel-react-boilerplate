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
        // TODO:: needs to be checked weather user has passive user permissions or not
        if ($user->status == 'passive') {
            throw new ForbiddenException("You don't have permission to get passive user");
        }
    }

    protected function checkOwnerPermission(User $user, User $actor)
    {
        // TODO:: needs to be added "any" permission to find any user
        if ($user->id != $actor->id) {
            throw new ForbiddenException("No permission for this user.");
        }
    }

    protected function checkPermissionAndGetExistingUser(string $id, User $actor = null): User
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
