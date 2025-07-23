<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaxRate;
use App\Models\TaxClass;

class TaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxClasses = \App\Models\TaxClass::all();
        $countries = \App\Models\Country::all();
        $defaultRates = [
            'Standard' => 10,
            'Reduced' => 8,
            'Zero' => 0,
        ];
        foreach ($taxClasses as $taxClass) {
            foreach ($countries as $country) {
                \App\Models\TaxRate::create([
                    'tax_class_id' => $taxClass->id,
                    'country_id' => $country->id,
                    'state_id' => null,
                    'rate' => $defaultRates[$taxClass->name] ?? 0.00,
                ]);
                // Optionally, seed state-level rates:
                foreach ($country->states as $state) {
                    \App\Models\TaxRate::create([
                        'tax_class_id' => $taxClass->id,
                        'country_id' => $country->id,
                        'state_id' => $state->id,
                        'rate' => $defaultRates[$taxClass->name] ?? 0.00,
                    ]);
                }
            }
        }
    }
}
