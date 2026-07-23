<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;



// class seller extends Model

class seller extends Authenticatable
{
    use HasApiTokens,HasFactory,SoftDeletes;


     protected $table = 'sellers';

    protected $guarded=[];

    protected $dates = ['deleted_at'];


    // store_info','owner_document','store_document','bank_details'

    public function store_info(){
        return $this->hasOne(sellerStoreInformation::class,'seller_id','id');
    }

    public function seller_store_info(){
        return $this->hasOne(sellerStoreInformation::class,'id','parent_id');
    }


    public function owner_document(){
        return $this->hasMany(sellerDocument::class,'seller_id','id')->where('status','1')->where('document_type','1');
    }


    public function store_document(){
        return $this->hasMany(sellerDocument::class,'seller_id','id')->where('status','1')->where('document_type','2');
    }

    public function seller_bank_details(){
        return $this->hasOne(Bankdetails::class,'user_id','id')->where('type','1');
    }


    public function subcription_plan(){
        return $this->hasmany(SellerSubcriptionPlanBuy::class,'seller_id','id')->where('status','1')->where('payment_status',1);
    }

    public function country_details(){ 
        return $this->hasOne(country::class,'dial_code','country_code'); 
    }

    public function seller_category(){ 
        return $this->hasOne(SellerTypeCategory::class,'id','select_category'); 
    }

     public function Role_Action(){ 
        return $this->hasMany(sellermenuAction::class,'seller_id','id'); 
    }

    public function staffs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('type', '1');
    }

    public function highlights(){ 
        return $this->hasMany(Highlight::class,'seller_id','id')->where('type','2'); 
    }

    public function stories(){ 
        return $this->hasMany(Story::class,'seller_id','id')->where('type','2'); 
    }

    public function reels(){ 
        return $this->hasMany(Reel::class,'seller_id','id')->where('type','2'); 
    }
    
    
    
}