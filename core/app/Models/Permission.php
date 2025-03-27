<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Permission extends Model
{
    protected $guarded = ['id' , 'created_at' , 'updated_at'];

    public function roles()
    {
        return $this->hasMany(PermissionRole::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'target_id');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'id', 'target_id');
    }
    
}