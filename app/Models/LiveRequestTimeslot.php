<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveRequestTimeslot extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
     * Relationships
     */
    public function country_info()
    {
        return $this->belongsTo(country::class, 'country_id');
    }

}
