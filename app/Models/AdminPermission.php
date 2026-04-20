<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $guarded=[];

    public function module_details()
    {
        return $this->belongsTo(AdminModule::class, 'module_id', 'id');
    }
}
