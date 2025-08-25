<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('hour')
                    ->required(),
                TextInput::make('days')
                    ->required(),
                TextInput::make('note')
                    ->required(),

                Select::make('level_id')
                    ->label('Nivel')
                    ->relationship('level', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nombre del Nivel')
                            ->required()
                            ->maxLength(255),
                    ]),



                Repeater::make('swimmers')
                ->relationship('swimmers')
                ->schema([
                    TextInput::make('name')
                        ->label('Nombre del nadador')
                        ->required()
                        ->maxLength(255),

                ])




            ]);
    }
}
