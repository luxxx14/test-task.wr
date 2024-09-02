<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            ['name' => 'Продукт 1', 'price' => 190.99],
            ['name' => 'Продукт 2', 'price' => 125000.09],
            ['name' => 'Продукт 3', 'price' => 89055.00],
            ['name' => 'Продукт 4', 'price' => 78000.00],
            ['name' => 'Продукт 5', 'price' => 11500080.50],
            ['name' => 'Продукт 6', 'price' => 452006.51],
        ]);
    }
}
