<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orderdetail extends Model
{
    protected $guarded = [];

    protected $casts=[
        "return_image"=>'json'
    ];
    
    public function product_details(){
        return $this->hasOne(product::class,'id','product_id');

    }

    public function variation_details(){
        return $this->hasOne(ProductVariant::class,'id','variants_id');

    }

    
    public function order_details(){
        return $this->hasOne(Order::class,'id','order_id');

    }


    public function UserRatingReviewProvide(){
        return $this->hasOne(productRatings::class,'orderdetails_id','id');

    }


     public function order(){
        return $this->hasOne(Order::class,'id','order_id');

    }

    public function store_info(){
        return $this->hasOne(sellerStoreInformation::class,'id','store_id');

    }

     public function driver_details(){
        
        return $this->hasOne(DeliveryBoy::class,'id','delivery_boy_id');

    }

     public function user_details(){
        
        return $this->hasOne(User::class,'id','user_id');

    }

      public function exchange_new_size_data(){
        
        return $this->hasOne(size::class,'id','exchange_new_size');

    }

     public function chatRoomrecords(){
        
        return $this->hasOne(allproductchats::class,'unique_id','unique_id');

    }
    
      public function exchange_order_details(){
        return $this->hasOne(orderdetail::class,'p_orderdetails_id','id');
    }



        public function scopeOrderCreateStatus($query)
    {
        return $query->where(function ($q) {

            // payment_method = 3 → payment_status NOT IN (2,3)
            $q->where(function ($q1) {
                $q1->whereHas('order', function ($o) {
                    $o->where('payment_method', 3);
                })
                ->whereNotIn('payment_status', [2, 3]);
            })

            // OR payment_method != 3 → payment_status = 1
            ->orWhere(function ($q2) {
                $q2->whereHas('order', function ($o) {
                    $o->where('payment_method', '!=', 3);
                })
                ->where('payment_status', 1);
            });
        });
    }
    

}