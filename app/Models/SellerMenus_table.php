<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerMenus_table extends Model
{
    //
      protected $fillable = [
        'title',
        'route',
        'icon',
        'active_patterns',
        'parent_id',
        'order_by',
        'status'
    ];

    public function children()
    {
        return $this->hasMany(SellerMenus_table::class, 'parent_id')
            ->where('status', 1)
            ->orderBy('order_by');
    }

}
