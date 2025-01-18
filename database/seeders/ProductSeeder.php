<?php

namespace Database\Seeders;

use Faker\Factory;
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
        $faker    = Factory::create();
        $products = [];

        for ($i = 0; $i <= 5; $i++) {
            array_push($products, ['name' => 'Product ' . $i, 'price' => $faker->randomFloat(2, 10, 20), 'created_at' => now(), 'updated_at' => now()]);
        }

        DB::table('products')->insert($products);
    }
}
