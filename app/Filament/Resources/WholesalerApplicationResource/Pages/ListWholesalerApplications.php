<?php

namespace App\Filament\Resources\WholesalerApplicationResource\Pages;

use App\Filament\Resources\WholesalerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWholesalerApplications extends ListRecords
{
    protected static string $resource = WholesalerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
