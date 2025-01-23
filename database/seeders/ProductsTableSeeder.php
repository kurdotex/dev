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
            [
                'name' => 'Producto 1',
                'description' => 'Descripción del producto 1',
                'price' => 100.50,
                'stock' => 10,
            ],
            [
                'name' => 'Producto 2',
                'description' => 'Descripción del producto 2',
                'price' => 50.75,
                'stock' => 20,
            ],
        ]);
    }
}
