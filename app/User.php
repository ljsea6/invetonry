<?php

namespace App;

use App\Role;
use App\Inventory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users');
    }

    public function purchases()
    {
        return $this->belongsToMany(Inventory::class, 'sales', 'user_id', 'inventory_id')->withPivot(['total', 'state', 'quantity']);
    }
}
