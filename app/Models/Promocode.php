<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name_english',
        'name_arabic',
        'description_english',
        'description_arabic',
        'applicable_for',
        'discount_percent',
        'min_order_value',
        'upto_discount',
        'start_date',
        'end_date',
        'status',
    ];

    public function country_info()
    {
        return $this->belongsTo(country::class, 'country_id');
    }
}
