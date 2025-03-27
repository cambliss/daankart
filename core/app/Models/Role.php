<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id' , 'created_at' , 'updated_at'];

    public function users()
    {
        return $this->morphMany(RoleUser::class, 'role', 'target_type', 'target_id');
    }

    public function admins()
    {
        return $this->morphMany(RoleUser::class, 'role', 'target_type', 'target_id');
    }
   
    public function permissions()
    {
        return $this->hasMany(PermissionRole::class);
    }



}
