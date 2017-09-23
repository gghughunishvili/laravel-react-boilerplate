<?php

namespace App\Http\Requests\Permissions;

use App\Http\Requests\Request;

class Update extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->may('update-permissions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'display_name' => 'string|min:2',
            'description' => 'string|min:10',
        ];
    }
}
