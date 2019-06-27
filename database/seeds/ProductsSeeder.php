<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'producto 1',
            'description' => 'uno'
        ]);

        Product::create([
            'name' => 'producto 2',
            'description' => 'dos'
        ]);

        Product::create([
            'name' => 'producto 3',
            'description' => 'tres'
        ]);

        Product::create([
            'name' => 'producto 4',
            'description' => 'cuatro'
        ]);

        Product::create([
            'name' => 'producto 5',
            'description' => 'cinco'
        ]);

        Product::create([
            'name' => 'producto 6',
            'description' => 'seis'
        ]);
    }
}
