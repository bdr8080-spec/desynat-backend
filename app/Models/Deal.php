<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function category_details()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory_details()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }


     public function sellerDealrecord(){
          return  $this->hasMany(SellerDealProduct::class,'deal_id','id');

     }

    public function seller_enrolled()
    {
        return $this->hasOne(SellerDealProduct::class, 'deal_id', 'id')
            ->selectRaw('deal_id, COUNT(DISTINCT seller_id) as seller_count')
            ->groupBy('deal_id')
            ->withDefault([
                'seller_count' => 0
            ]);
    }





}