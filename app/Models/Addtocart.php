<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addtocart extends Model
{
    protected $guarded = [];
    
    public function product_variants(){
        return $this->hasOne(ProductVariant::class,'id','variants_id');
    }

    public function product(){
        return $this->hasOne(product::class,'id','product_id');
    }
    
     public function chatroom_data(){
        return $this->hasOne(allproductchats::class,'unique_id','unique_id');
    }

}