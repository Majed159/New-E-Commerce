<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
class Admin extends Authenticatable
{
    protected $guarded = 'admin';

    public function roles()
    {
        return $this->hasMany(AdminsRole::class, 'subAdminId');
    }
}
