<?php

namespace App\Filament\Resources\Levels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class LevelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Nombre del Nivel')
                    ->required()
                    ->maxLength(255),

                Select::make('program_id')
                    ->label('Programa')
                    ->relationship('program', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nombre del Programa')
                            ->required()
                            ->maxLength(255),
                    ]),

                Textarea::make('swimmer_paraments')
                    ->label('Parámetros del Nadador')
                    ->rows(3)
                    ->columnSpanFull(),

                Repeater::make('skills')
                    ->relationship('skills')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre de la Skill')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('index')
                            ->label('Orden')
                            ->required()
                            ->numeric(),

                        Repeater::make('subSkills')
                            ->relationship('subSkills')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre de la SubSkill')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->label('SubSkills')
                            ->addActionLabel('+ Agregar SubSkill')
                            ->reorderable(false)
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'SubSkill sin nombre')
                            ->defaultItems(0),
                    ])
                    ->label('Skills')
                    ->addActionLabel('+ Agregar Skill')
                    ->reorderable()
                    ->collapsible()
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string =>
                        ($state['index'] ?? '?') . '. ' . ($state['name'] ?? 'Skill sin nombre')
                    )
                    ->defaultItems(0)

            ]);
    }
}
