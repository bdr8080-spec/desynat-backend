<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class allproductchats extends Model
{
      protected $guarded=[];


      public function product_variation(){

            return $this->hasOne(ProductVariant::class,'id','variation_id');


      }

        public function user_details(){
            return $this->hasOne(User::class,'id','user_id');
      }

         public function seller_details(){
            return $this->hasOne(seller::class,'id','seller_id');
      }


}