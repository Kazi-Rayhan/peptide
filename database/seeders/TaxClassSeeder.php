<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaxClass;

class TaxClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaxClass::insert([
            ['name' => 'Standard', 'description' => 'Standard tax rate', 'rate' => 10],
            ['name' => 'Reduced', 'description' => 'Reduced tax rate', 'rate' => 5],
            ['name' => 'Zero', 'description' => 'Zero tax rate', 'rate' => 0],
        ]);
    }
}
