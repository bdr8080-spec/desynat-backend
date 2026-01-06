<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $guarded=[];
    /**
     * Relationships
     */
    public function seller_details()
    {
        return $this->belongsTo(seller::class, 'seller_id');
    }
}
