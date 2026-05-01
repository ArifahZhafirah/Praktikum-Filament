<?php

namespace App\Filament\Resources\Posts\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;


class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tags')
                    ->label('Tags')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->label('Title')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                ColorColumn::make('color'),
                ImageColumn::make('image')
                    ->disk('public'),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                IconColumn::make('published')
                    ->toggleable()
                    ->boolean(),
            ])->defaultSort('created_at', 'asc')
            
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
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload(),
            ])
                
            ->recordActions([
                ReplicateAction::make()
                    ->icon('heroicon-o-document-duplicate'),
                EditAction::make(),
                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation(),
                Action::make('status')
                    ->label('status change')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->schema([
                        Checkbox::make('published')
                        ->default(fn($record): bool => $record->published),
                    ])
                    ->action(function($record, $data) {
                        $record->update(['publshed' => $data['published']]);
                    })

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
