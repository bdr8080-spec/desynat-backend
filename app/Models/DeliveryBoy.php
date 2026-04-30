<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryBoy extends Authenticatable
{
    use HasApiTokens,HasFactory,SoftDeletes;

    protected $table = 'delivery_boys';

    protected $guarded=[];
    protected $dates = ['deleted_at'];
    

    public function vehicle_image(){
     return $this->hasMany(DeliveryBoyDocument::class,'delivery_boy_id','id')->where('status','1')->where('document_type','1');
    }

    public function identity_proof(){
     return $this->hasMany(DeliveryBoyDocument::class,'delivery_boy_id','id')->where('status','1')->where('document_type','2');
    }

    public function driving_license(){
     return $this->hasMany(DeliveryBoyDocument::class,'delivery_boy_id','id')->where('status','1')->where('document_type','3');
    }

    public function vehicle_insurance(){
     return $this->hasMany(DeliveryBoyDocument::class,'delivery_boy_id','id')->where('status','1')->where('document_type','4');
    }

    public function pollution_paper(){
     return $this->hasMany(DeliveryBoyDocument::class,'delivery_boy_id','id')->where('status','1')->where('document_type','5');
    }

    public function registration_certificate(){
     return $this->hasMany(DeliveryBoyDocument::class,'delivery_boy_id','id')->where('status','1')->where('document_type','6');
    }

    public function zone_info(){
     return $this->hasOne(Zone::class,'id','zone_id');
    }

    public function country_info(){
     return $this->hasOne(country::class,'id','country_id');
    }

    









}
