<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'city_id',
        'name_english',
        'name_arabic',
        'coordinates',
        'status',
    ];

    protected $casts = [
        'coordinates' => 'array', // automatically converts JSON <-> array
    ];

    // Relationships
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function serviceCity()
    {
        return $this->belongsTo(ServiceCity::class, 'city_id');
    }
}
