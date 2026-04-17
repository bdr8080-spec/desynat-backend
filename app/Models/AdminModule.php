<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminModule extends Model
{
    protected $guarded=[];

    public function permissions()
    {
        return $this->hasMany(AdminPermission::class, 'module_id');
    }
}
