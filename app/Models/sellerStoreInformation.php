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

}
