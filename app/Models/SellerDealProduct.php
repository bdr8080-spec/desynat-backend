<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerDealProduct extends Model
{
     protected $guarded=[];


     public function dealrecord(){
          return  $this->hasOne(Deal::class,'id','deal_id');

     }


}