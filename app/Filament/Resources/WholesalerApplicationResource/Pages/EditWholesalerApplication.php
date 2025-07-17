<?php

namespace App\Filament\Resources\WholesalerApplicationResource\Pages;

use App\Filament\Resources\WholesalerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWholesalerApplication extends EditRecord
{
    protected static string $resource = WholesalerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
