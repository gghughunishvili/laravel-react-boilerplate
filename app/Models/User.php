<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @SWG\Definition(definition="User", required={"name", "username", "email", "password"})
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, UuidTrait;
    use HasRoles;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @SWG\Property(format="char:36")
     * @var string
     */
    public $id;

    /**
     * @SWG\Property(example="John Doe")
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(example="johndoo",minimum=4,maximum=55)
     * @var string
     */
    public $username;

    /**
     * @SWG\Property(example="someone@example.com")
     * @var string
     */
    public $email;

    /**
     * @SWG\Property(minimum=6)
     * @var string
     */
    public $password;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Hash password
     * @param $pass
     */
    public function setPasswordAttribute($pass)
    {
        if ($pass) {
            $this->attributes['password'] = app('hash')->needsRehash($pass) ? Hash::make($pass) : $pass;
        }
    }

    public function findForPassport($identifier)
    {
        return $this->where('status', config('custom.user.status.active'))
            ->where(function ($query) use ($identifier) {
                $query->orWhere('email', $identifier)
                    ->orWhere('username', $identifier);
            })->first();
    }
}
