<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\country;

class sellerStoreInformation extends Model
{
    protected $guarded=[];

    public function country_info()
    {
        return $this->belongsTo(country::class, 'country', 'id');
    }

    

    public function seller_information()
    {
        return $this->hasone(seller::class, 'id', 'seller_id');
    }


    public function All_product()
    {
        return $this->hasMany(product::class, 'store_id', 'id');
    }


    



}