<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaxRatesTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'Standard', 'US', 'CA', '0.10'
            ],
            [
                'Reduced', 'GB', '', '0.05'
            ],
            [
                'Zero', 'DE', '', '0.00'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'tax_class', 'country_code', 'state_code', 'rate',
            // Instructions:
            // tax_class: Must match the name of a tax class (e.g., Standard, Reduced, Zero)
            // country_code: ISO2 country code (e.g., US, GB, DE)
            // state_code: (Optional) State code as in your states table (e.g., CA for California). Leave blank for country-level rates.
            // rate: The tax rate as a decimal (e.g., 0.20 for 20%)
        ];
    }
} 