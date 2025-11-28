<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    protected $guarded = [];

    public function country_info()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
