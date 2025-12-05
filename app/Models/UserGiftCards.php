<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGiftCards extends Model
{
    
    protected $guarded=[];


    public function gift_details(){

        return $this->hasOne(GiftCard::class,'id','gift_card_id');

    }



}
