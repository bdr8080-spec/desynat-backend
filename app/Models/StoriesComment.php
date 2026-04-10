<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoriesComment extends Model
{
    protected $guarded=[];

    public function admin_details()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function user_details()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
