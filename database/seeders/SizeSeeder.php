<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        
$size = [
    [
        'name' => 'XS'
    ],
    [
        'name' => 'S'
    ],
    [
        'name' => 'M'
    ],
    [
        'name' => 'L'
    ],
    [
        'name' => 'XL'
    ],
    [
        'name' => 'XXL'
    ],
    [
        'name' => '3XL',
    ],
    [
        'name' => '4XL',
    ],
    [
        'name' => '5XL'
    ],

];

foreach ($size as $val) {
    DB::table('sizes')->updateOrInsert(
        ['name' => $val['name']], // 👈 condition (unique by name)
        array_merge($val, [
            'updated_at' => now(),
            'created_at' => now(),
        ])
    );
}


    }
    
}