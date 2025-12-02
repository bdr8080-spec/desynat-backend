<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'type',
        'per_day_price',
    ];

    public function country_info()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
