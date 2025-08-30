<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ResourcePermissionTrait;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    use ResourcePermissionTrait;
    protected static ?string $model = Product::class;
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationGroup = 'Catalogue';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Product Tabs')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('General')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\TextInput::make('name')->required()->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $state, callable $set) {
                                    $set('slug', Str::slug($state));
                                })
                                ->helperText('Enter the product name as it will appear to customers.'),
                            Forms\Components\TextInput::make('slug')->required()->maxLength(255)
                                ->helperText('Unique URL slug for the product. Auto-generated from the name.'),
                            Forms\Components\Textarea::make('description')
                                ->helperText('Detailed product description.'),
                            Forms\Components\Select::make('category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->nullable()
                                ->helperText('Assign a category for better organization.'),
                            Forms\Components\Select::make('tax_class_id')
                                ->label('Tax Class')
                                ->relationship('taxClass', 'name')
                                //    ->searchable()
                                ->nullable()
                                ->helperText('Assign a tax class for this product.'),
                            Forms\Components\Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'active' => 'Active',
                                    'archived' => 'Archived',
                                ])
                                ->default('draft')
                                ->required()
                                ->helperText('Set the product status.')
                        ]),

                    Forms\Components\Tabs\Tab::make('Media')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\FileUpload::make('thumbnail')
                                ->label('Thumbnail')
                                ->image()
                                ->directory('products/thumbnails')
                                ->nullable()
                                ->helperText('Main product image (shown in listings).')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                ->maxSize(2048),
                            Forms\Components\FileUpload::make('gallery')
                                ->label('Gallery Images')
                                ->image()
                                ->multiple()
                                ->directory('products/gallery')
                                ->nullable()
                                ->helperText('Additional images for the product gallery.')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                ->maxSize(2048),
                        ]),
                    Forms\Components\Tabs\Tab::make('Price')
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            Forms\Components\Grid::make(5)
                                ->schema([
                                    Forms\Components\Fieldset::make('Retailer')
                                        ->schema([
                                            Forms\Components\TextInput::make('price.retailer.unit_price')->label('Unit Price')->numeric()->required()->columnSpanFull(),
                                       
                                        ]),
                                    Forms\Components\Fieldset::make('Wholesale 1')
                                        ->schema([
                                            Forms\Components\TextInput::make('price.wholesale_1.unit_price')->label('Unit Price')->numeric()->required(),
                                            Forms\Components\TextInput::make('price.wholesale_1.kit_price')->label('Kit Price')->numeric()->nullable(),
                                        ]),
                                    Forms\Components\Fieldset::make('Wholesale 2')
                                        ->schema([
                                            Forms\Components\TextInput::make('price.wholesale_2.unit_price')->label('Unit Price')->numeric()->required(),
                                            Forms\Components\TextInput::make('price.wholesale_2.kit_price')->label('Kit Price')->numeric()->nullable(),
                                        ]),
                                    Forms\Components\Fieldset::make('Distributor 1')
                                        ->schema([
                                            Forms\Components\TextInput::make('price.distributor_1.unit_price')->label('Unit Price')->numeric()->required(),
                                            Forms\Components\TextInput::make('price.distributor_1.kit_price')->label('Kit Price')->numeric()->nullable(),
                                        ]),
                                    Forms\Components\Fieldset::make('Distributor 2')
                                        ->schema([
                                            Forms\Components\TextInput::make('price.distributor_2.unit_price')->label('Unit Price')->numeric()->required(),
                                            Forms\Components\TextInput::make('price.distributor_2.kit_price')->label('Kit Price')->numeric()->nullable(),
                                        ]),
                                ]),

                        ])->maxWidth('full')->columns(1)->columnSpanFull(),
                    Forms\Components\Tabs\Tab::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Forms\Components\TextInput::make('meta_title')->label('Meta Title')->maxLength(255),
                            Forms\Components\Textarea::make('meta_description')->label('Meta Description'),
                            Forms\Components\TextInput::make('meta_keywords')->label('Meta Keywords'),
                            Forms\Components\TextInput::make('tags')->label('Tags')
                                ->helperText('Enter tags separated by commas.'),
                        ]),
                ])->maxWidth('full')
                ->columns(2)
                ->columnSpanFull()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('thumbnail')->label('Thumbnail')->size(40),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('taxClass.name')->label('Tax Class')->sortable(),
            Tables\Columns\TextColumn::make('variants')
                ->label('Variants')
                ->formatStateUsing(function ($state, $record) {
                    if (is_array($record->variants) && count($record->variants) > 0) {
                        $variantNames = collect($record->variants)->pluck('name')->implode(', ');
                        return $variantNames;
                    }
                    return '-';
                })
                ->tooltip('Shows all variant names'),
            Tables\Columns\TextColumn::make('status')->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'draft' => 'Draft',
                    'active' => 'Active',
                    'archived' => 'Archived',
                ]),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
