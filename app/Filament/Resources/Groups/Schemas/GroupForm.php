<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

use App\Models\Skill;
use App\Models\Swimmer;
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
                    ->live() // Ya tenías esto correctamente
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
                    ->createOptionForm(function (Get $get): array {
                        $levelId = $get('level_id'); // Acceso directo desde aquí

                        return [
                            TextInput::make('name')
                                ->label('Nombre del Nadador')
                                ->required()
                                ->maxLength(255),

                            Select::make('skill_id')
                                ->label('Objetivo')
                                ->options(
                                    $levelId
                                        ? Skill::where('level_id', $levelId)->pluck('name', 'id')->toArray()
                                        : []
                                )
                                ->required()
                                ->searchable()
                                ->placeholder($levelId ? 'Selecciona un objetivo' : 'Selecciona un nivel primero')
                                ->disabled(!$levelId),
                        ];
                    })
            ]);
    }
}
