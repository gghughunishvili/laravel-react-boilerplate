<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
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
        return Role::where('name', $name)->first();
    }
}
