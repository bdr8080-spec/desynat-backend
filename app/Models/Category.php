<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relationship:
     * A Category can have many SubCategories.
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
}
