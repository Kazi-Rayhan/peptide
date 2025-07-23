<?php

namespace App\Filament\Resources\TaxRateResource\Pages;

use App\Filament\Resources\TaxRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TaxRatesExport;
use App\Exports\TaxRatesTemplateExport;
use App\Imports\TaxRatesImport;
use Illuminate\Http\UploadedFile;

class ListTaxRates extends ListRecords
{
    protected static string $resource = TaxRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Export Tax Rates')
                ->label('Export Tax Rates')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => Excel::download(new TaxRatesExport, 'tax_rates.xlsx')),
            Action::make('Download Template')
                ->label('Download Template')
                ->icon('heroicon-o-document-arrow-down')
                ->action(fn () => Excel::download(new TaxRatesTemplateExport, 'tax_rates_template.xlsx')),
            Action::make('Import Tax Rates')
                ->label('Import Tax Rates')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('Excel/CSV File')
                        ->acceptedFileTypes(['.csv', '.xlsx'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $file = $data['file'];
                    if ($file instanceof UploadedFile) {
                        Excel::import(new TaxRatesImport, $file);
                        Notification::make()
                            ->title('Import complete')
                            ->success()
                            ->body('Tax rates have been imported. Please check for any skipped rows due to invalid codes.')
                            ->send();
                    }
                })
                ->modalHeading('Import Tax Rates')
                ->modalDescription('Upload an Excel or CSV file with columns: tax_class, country_code, state_code, rate.\n\n- tax_class: Must match the name of a tax class (e.g., Standard, Reduced, Zero)\n- country_code: ISO2 country code (e.g., US, GB, DE)\n- state_code: (Optional) State code as in your states table (e.g., CA for California). Leave blank for country-level rates.\n- rate: The tax rate as a decimal (e.g., 0.20 for 20%)'),
        ];
    }
}
