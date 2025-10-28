<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class seller extends Model
{
    use HasApiTokens;

    protected $guarded=[];


    // store_info','owner_document','store_document','bank_details'

    public function store_info(){
        return $this->hasOne(sellerStoreInformation::class,'seller_id','id');
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

    
}
