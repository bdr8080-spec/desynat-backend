<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateProduct extends Model
{
    protected $guarded=[];


    public function affiliate_details(){
        return $this->hasOne(AffilatedUser::class,'id','affiliate_id');
    }

    public function product(){
        return $this->hasOne(product::class,'id','product_id');
    }

    public function affiliate_product_link()
    {
        return $this->hasOne(ProductLink::class, 'product_id', 'product_id');
    }

}