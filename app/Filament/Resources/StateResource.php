<?php

namespace App\Filament\Resources;

use App\Models\State;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\StateResource\Pages;

class StateResource extends Resource
{
    protected static ?string $model = State::class;
    protected static ?string $navigationGroup = 'Geography';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('state_code')->required()->maxLength(10),
            Forms\Components\Select::make('country_id')
                ->relationship('country', 'name')
                ->required()
                ->searchable()
                ->label('Country'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('state_code')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('country.name')->label('Country'),
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
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }
} 