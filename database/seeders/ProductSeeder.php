<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Indomie Goreng',
            'price' => 3500,
            'stock' => 50,
            'description' => 'Mi instan goreng rasa original.',
        ]);

        Product::create([
            'name' => 'Teh Botol',
            'price' => 5000,
            'stock' => 35,
            'description' => 'Minuman teh siap minum.',
        ]);

        Product::create([
            'name' => 'Beras 5 Kg',
            'price' => 75000,
            'stock' => 20,
            'description' => 'Beras kemasan 5 kilogram.',
        ]);

        Product::create([
            'name' => 'Sabun Cuci',
            'price' => 12000,
            'stock' => 25,
            'description' => 'Sabun untuk mencuci pakaian.',
        ]);

        Product::create([
            'name' => 'Roti Cokelat',
            'price' => 8000,
            'stock' => 40,
            'description' => 'Roti lembut dengan isian cokelat.',
        ]);
    }
}
