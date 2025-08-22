<?php

namespace App\Filament\Resources\Levels\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;

class LevelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre del Nivel')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('program.name')
                    ->label('Programa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('skills_count')
                    ->label('Skills')
                    ->counts('skills')
                    ->sortable(),

                TextColumn::make('swimmer_paraments')
                    ->label('Parámetros')
                    ->limit(50)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('program_id')
                    ->label('Programa')
                    ->relationship('program', 'name'),
            ])
            ->recordActions([
                Action::make('edit')
                    ->url(fn ($record) => route('filament.admin.resources.levels.edit', ['record' => $record]))
                    ->openUrlInNewTab(),

                Action::make('delete')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->delete()),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
