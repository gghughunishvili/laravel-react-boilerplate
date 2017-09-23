<?php

namespace App\Http\Requests\Permissions;

use App\Http\Requests\Request;

class Create extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->may('create-permissions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles|string|min:2',
            'display_name' => 'required|string|min:2',
            'description' => 'required|string|min:10',
        ];
    }
}
