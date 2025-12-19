<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productRatings extends Model
{
     protected $guarded=[];

     protected $casts=[
          'product_image'=>'array',
          'store_image'=>'array'
     ];
}