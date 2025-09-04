<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

use App\Models\Skill;
use App\Models\Swimmer;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del Grupo')
                    ->schema([
                        TimePicker::make('hour')
                            ->required(),

                        Select::make('days')
                            ->options([
                                'L,M,V' => 'Lunes, Miercoles y Viernes',
                                'M,J' => 'Martes y Jueves',
                                'V' => 'Viernes',
                                'S' => 'Sabado',
                            ])
                            ->required(),

                        TextInput::make('note')
                            ->required(),

                        Select::make('level_id')
                            ->label('Nivel')
                            ->relationship('level', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Limpiar swimmers cuando cambie el nivel
                                $set('swimmers', []);
                            })
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nombre del Nivel')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columns(2),

                Section::make('Nadadores del Grupo')
                    ->schema([
                        Repeater::make('swimmers')
                            ->relationship() // Mantiene la relación con swimmers existentes
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre del Nadador')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                Select::make('skill_id')
                                    ->label('Objetivo')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->options(function (Get $get): array {
                                        $level = $get('../../level_id');
                                        return $level
                                            ? Skill::where('level_id', $level)->pluck('name', 'id')->toArray()
                                            : [];
                                    })
                                    ->placeholder(function (Get $get): string {
                                        $level = $get('../../level_id');
                                        return $level ? 'Selecciona un objetivo' : 'Selecciona un nivel primero';
                                    })
                                    ->disabled(function (Get $get): bool {
                                        return !$get('../../level_id');
                                    })
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->addActionLabel('+ Agregar Nadador')
                            ->defaultItems(0)
                            ->collapsible()
                            ->collapsed(false)
                            ->cloneable()
                            ->reorderable()
                            ->deletable()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Nuevo Nadador')
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                return $data;
                            }),
                    ])
                    ->collapsed(false),
            ]);
    }
}
