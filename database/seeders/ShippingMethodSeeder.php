<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShippingZone;
use App\Models\ShippingMethod;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $europe = ShippingZone::where('name', 'Europe')->first();
        $na = ShippingZone::where('name', 'North America')->first();
        $rest = ShippingZone::where('name', 'Rest of World')->first();
        $methods = [
            ['shipping_zone_id' => $europe->id, 'name' => 'Flat Rate', 'type' => 'flat_rate', 'rate' => 10.00],
            ['shipping_zone_id' => $europe->id, 'name' => 'Free Shipping', 'type' => 'free_shipping', 'rate' => null],
            ['shipping_zone_id' => $na->id, 'name' => 'Flat Rate', 'type' => 'flat_rate', 'rate' => 15.00],
            ['shipping_zone_id' => $na->id, 'name' => 'Local Pickup', 'type' => 'local_pickup', 'rate' => null],
            ['shipping_zone_id' => $rest->id, 'name' => 'Flat Rate', 'type' => 'flat_rate', 'rate' => 25.00],
        ];
        foreach ($methods as $method) {
            ShippingMethod::create($method);
        }
    }
}
