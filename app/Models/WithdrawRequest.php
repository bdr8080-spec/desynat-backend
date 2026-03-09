<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    protected $guarded=[];

    public function bank_details()
    {
        return $this->belongsTo(Bankdetails::class, 'bankdetails_id');
    }
    public function affiliate__details()
    {
        return $this->belongsTo(AffilatedUser::class, 'user_id');
    }
}
