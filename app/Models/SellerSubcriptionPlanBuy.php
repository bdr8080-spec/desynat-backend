<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerSubcriptionPlanBuy extends Model
{

protected $table = 'seller_subcription_plan_buys';

 protected $guarded=[];


        function seller_details(){

            return $this->hasOne(seller::class,'id','seller_id');
            
            
        }

        public function plan_info()
        {
            return $this->belongsTo(Plan::class, 'plan_id', 'id');
        }


}