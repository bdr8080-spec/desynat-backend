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



}