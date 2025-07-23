<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxRateResource\Pages;
use App\Filament\Resources\TaxRateResource\RelationManagers;
use App\Models\TaxRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Country;
use App\Models\State;

class TaxRateResource extends Resource
{
    protected static ?string $model = TaxRate::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tax_class_id')
                    ->relationship('taxClass', 'name')
                    ->required(),
                Forms\Components\Select::make('country_id')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->helperText('Select the country for this tax rate.'),
                Forms\Components\Select::make('state_id')
                    ->relationship('state', 'name')
                    ->searchable()
                    ->helperText('Select a state or province.')
                    ->visible(fn ($get) => !empty($get('country_id')))
                    ->reactive(),
                Forms\Components\TextInput::make('rate')->numeric()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('taxClass.name')->label('Tax Class')->sortable(),
                Tables\Columns\TextColumn::make('country.name')->label('Country'),
                Tables\Columns\TextColumn::make('state.name')->label('State/Province'),
                Tables\Columns\TextColumn::make('rate'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxRates::route('/'),
            'create' => Pages\CreateTaxRate::route('/create'),
            'edit' => Pages\EditTaxRate::route('/{record}/edit'),
        ];
    }
}
