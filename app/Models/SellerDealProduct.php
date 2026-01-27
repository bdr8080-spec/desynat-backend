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

    public function product_added()
    {
        return $this->hasOne(self::class, 'seller_id', 'seller_id')
            ->whereColumn('deal_id', 'deal_id') // ensures same deal_id
            ->selectRaw('deal_id, seller_id, COUNT(DISTINCT product_id) as product_count')
            ->groupBy('deal_id', 'seller_id')
            ->withDefault([
                'product_count' => 0
            ]);
    }





}