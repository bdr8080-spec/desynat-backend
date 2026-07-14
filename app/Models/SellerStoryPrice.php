<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerStoryPrice extends Model
{
    protected $guarded=[];

    public function country_info()
    {
        return $this->belongsTo(country::class, 'country_id');
    }
}
