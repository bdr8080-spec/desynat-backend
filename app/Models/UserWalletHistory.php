<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWalletHistory extends Model
{
    protected $guarded=[];


    public function user_details(){

        return $this->hasOne(User::class,'id','user_id');
    }


}