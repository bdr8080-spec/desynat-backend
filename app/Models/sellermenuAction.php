<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sellermenuAction extends Model
{
     protected $guarded=[];

       public function sellermenu(){ 
        return $this->hasMany(SellerMenus_table::class,'id','menu_id'); 
    }

     public function singleActionmenu(){ 
        return $this->hasOne(SellerMenus_table::class,'id','menu_id'); 
    }
}
