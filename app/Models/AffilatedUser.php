<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class AffilatedUser extends Authenticatable
{
     use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

     protected $guarded=[];
     protected $dates = ['deleted_at'];

     public function address_details(){
      return $this->hasOne(AffilatedUserAddress::class,'affiliate_id','id');
     }

     public function bank_details(){
      return $this->hasMany(Bankdetails::class,'user_id','id')->where('type','3')->where('type','3');
     }

     public function country_details(){
      return $this->belongsTo(all_countrie::class,'country_code','dial_code');
     }

}