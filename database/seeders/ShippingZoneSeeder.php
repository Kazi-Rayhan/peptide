<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShippingZone;

class ShippingZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingZone::insert([
            ['name' => 'Europe', 'description' => 'All European countries'],
            ['name' => 'North America', 'description' => 'US, Canada, Mexico'],
            ['name' => 'Rest of World', 'description' => 'All other countries'],
        ]);
    }
}
