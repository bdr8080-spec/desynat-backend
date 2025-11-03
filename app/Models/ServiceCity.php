<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCity extends Model
{
    use HasFactory;

    /**
     * Allow mass assignment on all fields.
     */
    protected $guarded = [];

    /**
     * Relationship:
     * A ServiceCity belongs to one Country.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
