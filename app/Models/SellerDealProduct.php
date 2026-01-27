<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerDealProduct extends Model
{
     protected $guarded=[];


     public function dealrecord(){
          return  $this->hasOne(Deal::class,'id','deal_id');

     }

     public function product_details(){
          return  $this->hasOne(product::class,'id','product_id');

     }

     public function seller_details()
    {
        return $this->belongsTo(seller::class, 'seller_id', 'id');
    }






}