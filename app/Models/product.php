<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $guarded=[];


    public function product_specifications(){
        return $this->hasMany(ProductSpecification::class,'product_id','id');
    }

    public function product_variants(){
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }

}