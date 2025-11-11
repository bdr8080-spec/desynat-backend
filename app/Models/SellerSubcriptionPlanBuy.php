<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerSubcriptionPlanBuy extends Model
{

 protected $guarded=[];


        function seller_details(){

            return $this->hasOne(seller::class,'id','seller_id');
            
            
        }


}