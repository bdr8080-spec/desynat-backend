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
    


}
