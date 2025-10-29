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
        DB::table('admins')->insert([
            [
                'full_name' => 'Admin',
                'country_code' => '+91',
                'mobile' => '9988776655',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$pXzBkVAq.VWXvkmDG0O2ousci7iZv92TT68i6zMmvNdWhOsA3MeCW',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}