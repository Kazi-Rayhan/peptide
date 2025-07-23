<?php

namespace Database\Seeders;

use App\Constants\Country as ConstantsCountry;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = file_get_contents(public_path('json/states.json'));
        $regions = ConstantsCountry::regions();
        $countries = json_decode($countries, true);

        foreach ($regions as $key => $region) {
            Region::updateOrCreate(['name' => $region], ['name' => $region, 'slug' => $key]);
        }

        foreach ($countries['data'] as $country) {
            $regionKeys = ConstantsCountry::regionsByCountryCode($country['iso2']);
            $countryModel = Country::updateOrCreate([
                'iso2' => $country['iso2'],
            ], [
                'name' => $country['name'],
                'iso3' => $country['iso3'],
                'iso2' => $country['iso2'],
            ]);

            // Attach all regions for this country
            $regionIds = \App\Models\Region::whereIn('slug', $regionKeys)->pluck('id')->toArray();
            $countryModel->regions()->sync($regionIds);

            foreach ($country['states'] as $state) {
                $countryModel->states()->updateOrCreate(['state_code' => $state['state_code']], [
                    'name' => $state['name'],
                    'state_code' => $state['state_code'] ?: strtoupper(str_replace(' ', '_', $state['name'])),
                ]);
            }
        }
    }
}
