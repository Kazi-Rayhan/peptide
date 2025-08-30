<?php
namespace App\Filament\Resources\NewsletterSubscriptionResource\Pages;

use App\Exports\NewsletterSubscribersExport;
use App\Filament\Resources\NewsletterSubscriptionResource;
use App\Imports\NewsletterSubscribersImport;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListNewsletterSubscriptions extends ListRecords
{
    protected static string $resource = NewsletterSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('importExcel')
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    FileUpload::make('file')
                        ->label('Excel file (.xlsx, .csv)')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                        ])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $path = Storage::disk('public')->path($data['file']);
                    Excel::import(new NewsletterSubscribersImport, $path);
                    $this->notify('success', 'Import completed successfully.');
                }),

            Actions\Action::make('exportExcel')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    return Excel::download(new NewsletterSubscribersExport, 'newsletter-subscribers.xlsx');
                }),
        ];
    }
}
