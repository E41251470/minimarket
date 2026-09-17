<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'PT Indofood Sukses Makmur',
            'phone' => '02157958822',
            'address' => 'Jakarta Selatan',
        ]);

        Supplier::create([
            'name' => 'PT Unilever Indonesia Tbk',
            'phone' => '02127823900',
            'address' => 'Tangerang, Banten',
        ]);

        Supplier::create([
            'name' => 'PT Wings Surya',
            'phone' => '0318533300',
            'address' => 'Surabaya, Jawa Timur',
        ]);
    }
}
