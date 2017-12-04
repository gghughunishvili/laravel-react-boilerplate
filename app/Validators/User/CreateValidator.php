<?php

namespace App\Validators\User;

use App\Validators\Validator;

class CreateValidator extends Validator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|min:4|max:55|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
