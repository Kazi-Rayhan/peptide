<?php

namespace App\Filament\Resources\WholesalerApplicationResource\Pages;

use App\Filament\Resources\WholesalerApplicationResource;
use Filament\Resources\Pages\Page;

class ViewWholesalerApplication extends Page
{
    protected static string $resource = WholesalerApplicationResource::class;
    public static string $view = 'filament.resources.wholesaler-application-resource.pages.view';

    public $record;
    public $details;

    public function mount($record): void
    {
        $this->record = $this->getRecord($record);
        $this->details = json_decode($this->record->details, true);
    }

    public function getRecord($id)
    {
        $model = static::getResource()::getModel();
        return $model::findOrFail($id);
    }
} 