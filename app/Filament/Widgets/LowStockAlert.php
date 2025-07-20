<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LowStockAlert extends BaseWidget
{
    protected static ?string $heading = 'Low Stock Alert';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        try {
            return Auth::user()?->can('dashboard.products') ?? false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                  ->where('stock', '<', 10)
                   
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('stock')
                    ->label('Current Stock')
                    ->formatStateUsing(function ($record) {
                        $minStock = collect($record->variants)
                            ->pluck('stock')
                            ->filter()
                            ->min();
                        return $minStock ?? 0;
                    })
                    ->sortable()
                    ->color(function ($record) {
                        $stock = collect($record->variants)->pluck('stock')->filter()->min() ?? 0;
                        return $stock <= 5 ? 'danger' : 'warning';
                    })
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(function ($record) {
                        $minPrice = $record->getMinPrice();
                        $maxPrice = $record->getMaxPrice();
                        if ($minPrice == $maxPrice) {
                            return '$' . number_format($minPrice, 2);
                        }
                        return '$' . number_format($minPrice, 2) . ' - $' . number_format($maxPrice, 2);
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->getStateUsing(fn ($record) => $record->status === 'active'),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Update Stock')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (Product $record): string => route('filament.admin.resources.products.edit', $record))
                    ->openUrlInNewTab(),
            ]);
    }
} 