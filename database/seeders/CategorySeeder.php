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
                'image' => 'https://pixabay.com/photos/woman-model-portrait-pose-style-3567600/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Men',
                'description' => 'test description',
                'image' => 'https://www.shutterstock.com/image-photo/smiling-young-middle-eastern-man-digital-2063524544',
                'created_at' => now(),
            ],  'updated_at' => now(),
            [
                'name' => 'Kids',
                'description' => 'test description',
                'image' => 'https://www.shutterstock.com/image-photo/cute-little-boy-playing-wooden-toys-2471818291',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
