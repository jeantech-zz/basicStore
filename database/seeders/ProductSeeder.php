<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run():void
    {
        Product::create(
            [
            'code' => '1000',
            'name' => 'LavaLoza',
            'description' => 'Jabon de lavar loza',
            'price' => 10000,
            'quantity' =>  20,
            'disable_at' => now(),
            'image' => '/storage/products/jabon',
        ]);
    }
}
