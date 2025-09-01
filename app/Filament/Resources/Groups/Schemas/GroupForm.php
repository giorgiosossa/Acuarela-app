<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use App\Models\Skill;

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
                    ->live() // Importante: hace que el campo sea reactivo
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nombre del Nivel')
                            ->required()
                            ->maxLength(255),
                    ]),

                Select::make('swimmer')
                    ->label('Nadador')
                    ->relationship('swimmers', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nombre del Nadador')
                            ->required()
                            ->maxLength(255),

                        Select::make('skill_id')
                            ->label('Objetivo')
                            ->required()
                            ->searchable()
                            ->live() // Hace el campo reactivo
                            ->afterStateUpdated(function (Get $get) {
                                $currentLevel = $get('level_id');
                            })

                    ]),
            ]);
    }
}
