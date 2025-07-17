<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WholesalerApplicationResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Collection;

class WholesalerApplicationResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $navigationLabel = 'Wholesaler Applications';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereNotNull('details')
            ->where('is_wholesaler', false)
            ->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                            ]),
                    ]),

                Section::make('Company Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('company_name')
                                    ->label('Company Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('company_registration')
                                    ->label('Registration Number')
                                    ->maxLength(255)
                                    ->placeholder('VAT, Tax ID, etc.'),
                            ]),
                        
                        Textarea::make('company_address')
                            ->label('Company Address')
                            ->required()
                            ->rows(3)
                            ->maxLength(500),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('company_phone')
                                    ->label('Company Phone')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),
                                TextInput::make('company_website')
                                    ->label('Company Website')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://example.com'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('business_type')
                                    ->label('Business Type')
                                    ->options([
                                      'pharmaceutical' => 'Pharmaceutical',
                                      'biotechnology' => 'Biotechnology',
                                      'research_institute' => 'Research Institute',
                                      'university' => 'University',
                                      'hospital' => 'Hospital',
                                      'laboratory' => 'Laboratory',
                                      'distributor' => 'Distributor',
                                      'other' => 'Other',
                                    ])
                                    ->required(),
                                Select::make('industry')
                                    ->label('Industry')
                                    ->options([
                                       'healthcare' => 'Healthcare',
                                        'life_sciences' => 'Life Sciences',
                                        'academic' => 'Academic',
                                        'clinical_research' => 'Clinical Research',
                                        'drug_development' => 'Drug Development',
                                       'biomedical' => 'Biomedical',
                                       'other' => 'Other',
                                    ])
                                    ->required(),
                            ]),

                        Select::make('expected_volume')
                            ->label('Expected Monthly Order Volume')
                            ->options([
                               'small' => 'Small (1-10 units)',
                           'medium' => 'Medium (11-50 units)',
                               'large' => 'Large (51-100 units)',
                               'enterprise' => 'Enterprise (100+ units)',
                            ])
                            ->required(),
                    ])
                    ->collapsible(),

                Section::make('Application Status')
                    ->schema([
                        Toggle::make('is_wholesaler')
                            ->label('Approve as Wholesaler')
                            ->helperText('Enable this to approve the wholesaler application')
                            ->onColor('success')
                            ->offColor('danger'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                static::getModel()::query()
                    ->whereNotNull('details')
                    ->where('is_wholesaler', false)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Applicant Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('company_name')
                    ->label('Company')
                    ->getStateUsing(function (Model $record): string {
                        $details = json_decode($record->details, true);
                        return $details['company_name'] ?? 'N/A';
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('business_type')
                    ->label('Business Type')
                    ->getStateUsing(function (Model $record): string {
                        $details = json_decode($record->details, true);
                        return ucfirst(str_replace('_', ' ', $details['business_type'] ?? 'N/A'));
                    })
                    ->badge()
                    ->color('info'),

                TextColumn::make('industry')
                    ->label('Industry')
                    ->getStateUsing(function (Model $record): string {
                        $details = json_decode($record->details, true);
                        return ucfirst(str_replace('_', ' ', $details['industry'] ?? 'N/A'));
                    })
                    ->badge()
                    ->color('success'),

                TextColumn::make('expected_volume')
                    ->label('Expected Volume')
                    ->getStateUsing(function (Model $record): string {
                        $details = json_decode($record->details, true);
                        $volume = $details['expected_volume'] ?? 'N/A';
                        return ucfirst($volume);
                    })
                    ->badge()
                    ->color('warning'),

                TextColumn::make('created_at')
                    ->label('Application Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(fn (Model $record): string => 'Pending Approval')
                    ->color('warning'),
            ])
            ->filters([
                SelectFilter::make('business_type')
                    ->label('Business Type')
                    ->options([
                      'pharmaceutical' => 'Pharmaceutical',
                      'biotechnology' => 'Biotechnology',
                      'research_institute' => 'Research Institute',
                       'university' => 'University',
                     'hospital' => 'Hospital',
                       'laboratory' => 'Laboratory',
                        'distributor' => 'Distributor',
                       'other' => 'Other',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['value'])) {
                            return $query->whereRaw("JSON_EXTRACT(details, '$.business_type') = ?", [$data['value']]);
                        }
                        return $query;
                    }),

                SelectFilter::make('industry')
                    ->label('Industry')
                    ->options([
                       'healthcare' => 'Healthcare',
                        'life_sciences' => 'Life Sciences',
                        'academic' => 'Academic',
                        'clinical_research' => 'Clinical Research',
                        'drug_development' => 'Drug Development',
                       'biomedical' => 'Biomedical',
                       'other' => 'Other',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['value'])) {
                            return $query->whereRaw("JSON_EXTRACT(details, '$.industry') = ?", [$data['value']]);
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Action::make('view_details')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Wholesaler Application Details')
                    ->modalContent(function (Model $record): \Illuminate\Contracts\View\View {
                        $details = json_decode($record->details, true);
                        return view('filament.resources.wholesaler-application-resource.partials.application-details', [
                            'user' => $record,
                            'details' => $details,
                        ]);
                    })
                    ->modalWidth('4xl'),

                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Wholesaler Application')
                    ->modalDescription('Are you sure you want to approve this wholesaler application? This will grant wholesaler privileges to the user.')
                    ->modalSubmitActionLabel('Yes, Approve')
                    ->action(function (Model $record): void {
                        $record->update([
                            'is_wholesaler' => true,
                          
                        ]);

                        Notification::make()
                            ->title('Application Approved')
                            ->body('The wholesaler application has been approved successfully.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Model $record): bool => !$record->is_wholesaler),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Wholesaler Application')
                    ->modalDescription('Are you sure you want to reject this wholesaler application? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Reject')
                    ->action(function (Model $record): void {
                        $record->update([
                            'customer_type' => 'retailer',
                           'role_id' => User::ROLE_CUSTOMER,
                           'details' => null,
                        ]);

                        Notification::make()
                            ->title('Application Rejected')
                            ->body('The wholesaler application has been rejected.')
                            ->danger()
                            ->send();
                    })
                    ->visible(fn (Model $record): bool => !$record->is_wholesaler),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Approve Selected Applications')
                        ->modalDescription('Are you sure you want to approve the selected wholesaler applications?')
                        ->modalSubmitActionLabel('Yes, Approve All')
                        ->action(function (Collection $records): void {
                            $records->each(function ($record) {
                                $record->update([
                                    'is_wholesaler' => true,
                                   'role_id' => User::ROLE_WHOLESALER,
                                ]);
                            });

                            Notification::make()
                                ->title('Applications Approved')
                                ->body("Successfully approved {$records->count()} wholesaler applications.")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('reject_selected')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Reject Selected Applications')
                        ->modalDescription('Are you sure you want to reject the selected wholesaler applications?')
                        ->modalSubmitActionLabel('Yes, Reject All')
                        ->action(function (Collection $records): void {
                            $records->each(function ($record) {
                                $record->update([
                                    'customer_type' => 'retailer',
                                   'role_id' => User::ROLE_CUSTOMER,
                                   'details' => null,
                                ]);
                            });

                            Notification::make()
                                ->title('Applications Rejected')
                                ->body("Successfully rejected {$records->count()} wholesaler applications.")
                                ->danger()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWholesalerApplications::route('/'),
        ];
    }
}
