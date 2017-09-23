<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\Request;
use App\Models\User;

class Update extends Request
{
    protected $forbiddenResponseMessage = 'No permission to update this user';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = $this->route('id');
        $user = User::getById($user_id);
        
        if (auth()->user()->may('update-users')) {
            return true;
        }

        if (auth()->user()->id == $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:255',
            'status' => 'in:active,passive,pending',
        ];
    }
}
