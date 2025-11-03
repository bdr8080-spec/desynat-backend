<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Women',
                'description' => 'test description',
                'image' => 'https://desynat-bucket.s3.me-south-1.amazonaws.com/images/u29R3gSkyy.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Men',
                'description' => 'test description',
                'image' => 'https://desynat-bucket.s3.me-south-1.amazonaws.com/images/PMwhx375j3.jpg',
                'created_at' => now(),
            ],  'updated_at' => now(),
            [
                'name' => 'Kids',
                'description' => 'test description',
                'image' => 'https://desynat-bucket.s3.me-south-1.amazonaws.com/images/957aW4plK9.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
