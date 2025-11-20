<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'plan_name_english',
        'plan_name_arabic',
        'duration',
        'duration_type',
        'new_duration',
        'new_duration_type',
        'no_of_videos',
        'no_of_products',
        'no_of_highlights',
        'no_of_employee',
        'stories',
        'price',
        'discounted_price',
        'commission',
        'commission_percentage',
        'status',
    ];

    protected $casts = [
        'price' => 'float',
        'discounted_price' => 'float',
        'commission_percentage' => 'float',
    ];

    public function country()
    {
        return $this->belongsTo(country::class);
    }

    public function country_info()
    {
        return $this->belongsTo(country::class, 'country_id', 'id');
    }

    
}
