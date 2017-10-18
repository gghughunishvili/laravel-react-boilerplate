<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
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
        return Permission::where('id', $id)->first();
    }

    public static function getByName($name)
    {
        return Permission::where('name', $name)->first();
    }
}
