<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orderdetail extends Model
{
    protected $guarded = [];


    public function product_details(){
        return $this->hasOne(product::class,'id','product_id');

    }

    public function variation_details(){
        return $this->hasOne(ProductVariant::class,'id','variants_id');

    }

    
    public function order_details(){
        return $this->hasOne(Order::class,'id','order_id');

    }


}