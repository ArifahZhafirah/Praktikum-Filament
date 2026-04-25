<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter; 
use Filament\Forms\Components\DatePicker;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('sku')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->money('IDR', true)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('stock')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('is_active')
                    ->label('Status')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                ])
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Non Active'),

                ImageColumn::make('image')
                    ->disk('public'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('created_at')
                    ->label('Creation Date')
                        ->schema([
                            DatePicker::make('created_at')
                                ->label('Select Date :'),
                        ])
                        ->query(function ($query, $data) {
                            return $query
                                ->when(
                                    $data['created_at'],
                                    fn ($query, $date) => $query->whereDate('Created_at', $date ),
                                );
                            }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
