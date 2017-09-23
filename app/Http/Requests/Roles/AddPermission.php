<?php

namespace App\Http\Requests\Roles;

use App\Http\Requests\Request;

class AddPermission extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->may('add-permissions-to-roles');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
