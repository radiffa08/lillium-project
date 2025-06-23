<?php

namespace Database\Seeders;

use Faker\Provider\Lorem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            DB::table('products')->insert([
                'product_name' => "Test Product $i",
                'is_on_sale' => true,
                'price' => 99.99,
                'description' => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Placeat, dolorum atque, illum quos blanditiis, similique porro quam sint alias accusamus quas consectetur odio commodi. Est corrupti fuga soluta doloremque assumenda?",
                'category_id' => rand(1, 3),
                'subcategory_id' => rand(1, 10)
            ]);
        }
    }
}
