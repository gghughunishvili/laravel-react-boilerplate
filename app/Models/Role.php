<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    public static function getById($id)
    {
        return Role::where('id', $id)->first();
    }

    public static function getByName($name)
    {
        return Role::where('name', $name)->first();
    }
}
