<?php

namespace App\Models\Permissions;

use App\Models\Roles\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
