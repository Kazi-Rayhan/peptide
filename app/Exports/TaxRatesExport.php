<?php

namespace App\Exports;

use App\Models\TaxRate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class TaxRatesExport implements FromCollection, WithHeadings, WithMapping, WithCustomStartCell
{
    public function collection()
    {
        return TaxRate::with(['taxClass', 'country', 'state'])->get();
    }

    public function map($rate): array
    {
        return [
            $rate->taxClass ? $rate->taxClass->name : '',
            $rate->country ? $rate->country->iso2 : '',
            $rate->state ? $rate->state->state_code : '',
            $rate->rate,
        ];
    }

    public function headings(): array
    {
        return [
            'tax_class', 'country_code', 'state_code', 'rate'
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }
} 