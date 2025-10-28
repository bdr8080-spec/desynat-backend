<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class seller extends Model
{
    use HasApiTokens;

    protected $guarded=[];
    
}
