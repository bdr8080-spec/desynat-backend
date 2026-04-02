<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveRequest extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
     * Relationships
     */
    public function timeslot_details()
    {
        return $this->belongsTo(LiveRequestTimeslot::class, 'timeslot_id');
    }

    public function seller_details()
    {
        return $this->belongsTo(seller::class, 'seller_id');
    }



}