<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded=[];
    protected $appends = ['sender_details'];

    public function ticket_type_details()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id', 'id');
    }

    public function getSenderDetailsAttribute()
    {
        switch ($this->sender_type) {
            case 1: return User::find($this->sender_id);
            case 2: return seller::find($this->sender_id);
            case 3: return AffilatedUser::find($this->sender_id);
            case 4: return DeliveryBoy::find($this->sender_id);
            default: return null;
        }
    }
}
