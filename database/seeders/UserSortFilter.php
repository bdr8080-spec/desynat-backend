<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;


class UserSortFilter extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            
        $filter = [
            [
                'name' => 'Recommended',
                'name_ar' => 'موصى به'
            ],
        
            [
                'name' => 'Price: Low to High',
                'name_ar' => 'السعر: من الأقل إلى الأعلى',
            ],
        
            [
                'name' => 'Price: High to Low',
                'name_ar' => 'السعر: من الأعلى إلى الأقل'
            ],
            [
                'name' => 'Newest First',
                'name_ar' => 'الأحدث أولاً'
            ],
            [
                'name' => 'Customer Rating',
                'name_ar' => 'تقييم العملاء'
            ],
            [
                'name' => 'Best selling',
                'name_ar' => 'الأكثر مبيعًا'
            ],
            [
                'name' => 'Fastest delivery',
                'name_ar' => 'أسرع توصيل'
            ],    
        ];

        

foreach ($filter as $val) {
    DB::table('sort_filters')->updateOrInsert(
        ['name' => $val['name']], // 👈 condition (unique by name)
        array_merge($val, [
            'updated_at' => now(),
            'created_at' => now(),
        ])
    );
}


    }
    
}