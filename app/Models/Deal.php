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
}
