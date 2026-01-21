<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class AffilatedUser extends Authenticatable
{
     use HasFactory, Notifiable, HasApiTokens;

     protected $guarded=[];
}