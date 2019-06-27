<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_users');
    }
}
