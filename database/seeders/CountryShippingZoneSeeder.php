<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingZone;
use App\Models\Country;

class CountryShippingZoneSeeder extends Seeder
{
    public function run(): void
    {
        $europe = ShippingZone::where('name', 'Europe')->first();
        $na = ShippingZone::where('name', 'North America')->first();
        $rest = ShippingZone::where('name', 'Rest of World')->first();

        $europeIso2 = [
            'FR', 'DE', 'GB', 'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'CH', 'NO', 'IS', 'LI', 'MC', 'SM', 'VA', 'RU', 'UA', 'BY', 'MD', 'ME', 'MK', 'AL', 'AD', 'BA', 'RS', 'SI', 'EE', 'LT', 'LV'
        ];
        $naIso2 = [
            'US', 'CA', 'MX', 'BZ', 'CR', 'SV', 'GT', 'HN', 'NI', 'PA', 'BS', 'BB', 'CU', 'DM', 'DO', 'GD', 'HT', 'JM', 'KN', 'LC', 'VC', 'TT'
        ];
        $allIso2 = Country::pluck('iso2')->toArray();
        $assigned = array_merge($europeIso2, $naIso2);
        $restIso2 = array_diff($allIso2, $assigned);

        if ($europe) {
            $europeCountryIds = Country::whereIn('iso2', $europeIso2)->pluck('id')->toArray();
            $europe->countries()->sync($europeCountryIds);
        }
        if ($na) {
            $naCountryIds = Country::whereIn('iso2', $naIso2)->pluck('id')->toArray();
            $na->countries()->sync($naCountryIds);
        }
        if ($rest) {
            $allCountryIds = Country::pluck('id')->toArray();
            $assignedIds = array_merge(
                Country::whereIn('iso2', $europeIso2)->pluck('id')->toArray(),
                Country::whereIn('iso2', $naIso2)->pluck('id')->toArray()
            );
            $restCountryIds = array_diff($allCountryIds, $assignedIds);
            $rest->countries()->sync($restCountryIds);
        }
    }
} 