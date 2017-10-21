<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use UuidTrait;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    public static function getByName($name)
    {
        return Permission::where('name', $name)->first();
    }
}
