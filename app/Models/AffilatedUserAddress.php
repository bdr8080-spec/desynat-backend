<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffilatedUserAddress extends Model
{
    protected $guarded=[];

    public function country_details(){
      return $this->belongsTo(country::class,'country','id');
     }
}