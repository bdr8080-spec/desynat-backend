<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $guarded=[];

    protected $casts=[
        'variant_image'=>'array'
    ];

    public function color(){
        return $this->hasOne(color::class,'id','color_id');
    }

    public function size(){    
        return $this->hasOne(size::class,'id','size_id');
    }


    public function product_details(){    
        return $this->hasOne(product::class,'id','product_id');
    }












}