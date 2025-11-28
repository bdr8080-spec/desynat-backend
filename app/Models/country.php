<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    protected $guarded=[];

    public function tax_info()
    {
        return $this->hasOne(Tax::class, 'country_id', 'id');
    }

    public function shipping_info()
    {
        return $this->hasMany(ShippingCharge::class, 'country_id', 'id');
    }
}
