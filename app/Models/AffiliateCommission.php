<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'commission',
        'status'
    ];

    public function country_info()
    {
        return $this->belongsTo(country::class, 'country_id', 'id');
    }
}
