<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function order_details(){
        
        return $this->hasMany(orderdetail::class,'order_id','id');

    }

    public function delivery_details(){
        
        return $this->hasOne(OrderDeliveryAddress::class,'id','delivery_address');

    }
    
       public function user_details(){
        
        return $this->hasOne(User::class,'id','user_id');

    }
    
       public function promocode_details(){
        
        return $this->hasOne(Promocode::class,'id','promocode_id');

    }
     public function giftCard_details(){
        
        return $this->hasOne(UserGiftCards::class,'id','giftcard_id');

    }
    




}