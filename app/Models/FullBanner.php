<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FullBanner extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function country_info()
    {
        return $this->belongsTo(all_countrie::class, 'country_id');
    }
}
