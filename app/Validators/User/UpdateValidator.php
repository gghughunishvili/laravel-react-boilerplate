<?php

namespace App\Validators\User;

use App\Validators\Validator;
use Illuminate\Validation\Rule;

class UpdateValidator extends Validator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:255',
            'status' => [
                Rule::in(config('custom.user.status')),
            ],
        ];
    }
}
