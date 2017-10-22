<?php

namespace App\Transformers;

use App\Models\User;
use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = [];

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        $data = [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'status' => (string) $user->status,
        ];

        return $data;
    }
}
