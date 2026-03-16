<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded=[];

    public function getReceiverDetailsAttribute()
    {
        switch ($this->receiver_type) {
            case 1: return Admin::find($this->receiver_id);
            case 2: return User::find($this->receiver_id);
            case 3: return seller::find($this->receiver_id);
            case 4: return AffilatedUser::find($this->receiver_id);
            case 5: return DeliveryBoy::find($this->receiver_id);
            default: return null;
        }
    }
    public function getSenderDetailsAttribute()
    {
        switch ($this->sender_type) {
            case 1: return Admin::find($this->sender_id);
            case 2: return User::find($this->sender_id);
            case 3: return seller::find($this->sender_id);
            case 4: return AffilatedUser::find($this->sender_id);
            case 5: return DeliveryBoy::find($this->sender_id);
            default: return null;
        }
    }
}
