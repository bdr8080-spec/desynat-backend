<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class allproductchats extends Model
{
      protected $guarded=[];


      public function product_variation(){

            return $this->hasOne(ProductVariant::class,'id','variation_id');


      }


}