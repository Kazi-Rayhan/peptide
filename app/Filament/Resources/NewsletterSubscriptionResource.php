<?php
namespace App\Filament\Resources;

use App\Exports\NewsletterSubscribersExport;
use App\Filament\Resources\NewsletterSubscriptionResource\Pages;
use App\Models\NewsletterSubscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterSubscriptionResource extends Resource
{
    protected static ?string $model = NewsletterSubscription::class;

    protected static ?string $navigationLabel = 'Subscribers';
    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralLabel     = 'Subscribers';
    protected static ?string $modelLabel      = 'Subscriber';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Name'),
                Forms\Components\TextInput::make('email')->label('Email')->email()->required(),
                Forms\Components\TextInput::make('contact_number')->label('Contact Number'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('contact_number'),
                Tables\Columns\TextColumn::make('created_at')->label('Subscribed At')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('Export')
                    ->action(function (EloquentCollection $records) {
                        $ids = $records->pluck('id')->toArray();
                        return Excel::download(new NewsletterSubscribersExport($ids), 'newsletter_subscribers.xlsx');
                    })
                    ->requiresConfirmation()
                    ->color('success'),
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
            'index'  => Pages\ListNewsletterSubscriptions::route('/'),
            'create' => Pages\CreateNewsletterSubscription::route('/create'),
            'edit'   => Pages\EditNewsletterSubscription::route('/{record}/edit'),
        ];
    }
}
