<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded=[];

    public function getReceiverDetailsAttribute()
    {
        switch ($this->receiver_type) {
            case 1:
                return Admin::find($this->receiver_id);

            case 2:
                return User::find($this->receiver_id);

            case 3:
                return seller::find($this->receiver_id);

            case 4:
                return AffilatedUser::find($this->receiver_id);

            case 5:
                return DeliveryBoy::find($this->receiver_id);

            default:
                return null;
        }
    }

    protected function getReceiverCountry($receiver, $type)
    {
        switch ($type) {
            case 1: // Admin
                // assuming Admin has country_code relation or country_id
                return $receiver->country_info ?? null;
            case 2: // User
                return $receiver->country_info ?? null;
            case 3: // Seller
                return $receiver->country_details ?? null;
            case 4: // AffiliatedUser
                // nested relation: address_details -> country_details
                return optional($receiver->address_details)->country_details;
            case 5: // DeliveryBoy
                return $receiver->country_info ?? null;
            default:
                return null;
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
