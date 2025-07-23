<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Models\Country;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;
    protected static ?string $navigationGroup = 'Geography';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('iso2')->required()->maxLength(2),
            Forms\Components\TextInput::make('iso3')->required()->maxLength(3),
            Forms\Components\Select::make('regions')
                ->relationship('regions', 'name')
                ->multiple()
                ->searchable()
                ->label('Regions'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('iso2')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('iso3')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('regions.name')->label('Regions')->limit(30),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
} 