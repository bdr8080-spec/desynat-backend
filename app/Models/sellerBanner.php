<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sellerBanner extends Model
{
       protected $guarded=[];


       public function category_details(){
       return $this->hasOne(Category::class,'id','category');
       }

       public function subcategory_details(){
       return $this->hasOne(SubCategory::class,'id','subcatgory');
       }

       public function seller_details(){
       return $this->hasOne(seller::class,'id','seller_id');
       }


       
}