<?php

namespace App\Imports;

use App\Models\TaxClass;
use App\Models\Country;
use App\Models\State;
use App\Models\TaxRate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TaxRatesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $taxClass = TaxClass::where('name', $row['tax_class'])->first();
        $country = Country::where('iso2', $row['country_code'])->first();
        $state = null;
        if (!empty($row['state_code']) && $country) {
            $state = State::where('state_code', $row['state_code'])->where('country_id', $country->id)->first();
        }
        if (!$taxClass || !$country) {
            // Skip invalid rows
            return null;
        }
        return TaxRate::updateOrCreate(
            [
                'tax_class_id' => $taxClass->id,
                'country_id' => $country->id,
                'state_id' => $state ? $state->id : null,
            ],
            [
                'rate' => $row['rate'],
            ]
        );
    }

    public function rules(): array
    {
        return [
            '*.tax_class' => 'required|string',
            '*.country_code' => 'required|string|size:2',
            '*.rate' => 'required|numeric',
        ];
    }
} 