<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhislistReel extends Model
{
    protected $guarded=[];

    public function reel_details()
    {
        return $this->belongsTo(Reel::class, 'reel_id', 'id');
    }
}
