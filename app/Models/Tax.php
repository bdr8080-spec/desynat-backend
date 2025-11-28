<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'tax',
        'status'
    ];

    public function country_info()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
