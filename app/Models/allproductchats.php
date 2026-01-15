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


      public function delivery_details(){ // get From Address table 
            return $this->hasOne(userAddress::class,'id','delivery_address');
      }

      public function order_create_status(){ 

          return $this->hasOne(Order::class, 'unique_id', 'unique_id')
            ->where(function ($q) {
                  $q->where(function ($q1) {
                        // payment_method = 3 → payment_status NOT IN (2,3)
                        $q1->where('payment_method', '3')
                        ->whereNotIn('payment_status', ['2', '3']);
                  })
                  ->orWhere(function ($q2) {
                        // payment_method != 3 → payment_status = 1
                        $q2->where('payment_method', '!=', '3')
                        ->where('payment_status', '1');
                  });
            });
      
      }
}