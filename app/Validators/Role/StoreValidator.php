<?php

namespace App\Validators\Role;

use App\Validators\Validator;

class StoreValidator extends Validator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255|unique:' . App\Models\Role::getTable(),
        ];
    }
}
