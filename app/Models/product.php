<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $guarded=[];

    public function brand(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function subcategory(){
        return $this->hasOne(SubCategory::class,'id','subcategory_id');
    }

    public function product_specifications(){
        return $this->hasMany(ProductSpecification::class,'product_id','id');
    }

    public function product_variants(){
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }



}