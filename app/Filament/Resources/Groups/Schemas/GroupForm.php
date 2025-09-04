<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
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
                    ->live() // Ya tenías esto correctamente
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nombre del Nivel')
                            ->required()
                            ->maxLength(255),
                    ]),

                Repeater::make('swimmers')
                    ->relationship('swimmers')
                    ->table([
                        TableColumn::make('name'),
                        TableColumn::make('skill')
                    ])
                    ->schema([

                                TextInput::make('name')
                                    ->label('Nombre del Nadador')
                                    ->required()
                                    ->maxLength(255),

                                Select::make('skill_id')
                                    ->label('Objetivo')
                                    ->required()
                                    ->searchable()

                                    ->preload()
                                    ->options(function (Get $get): array{
                                        $level = $get('../../level_id');
                                       return $level
                                            ? Skill::where('level_id', $level)->pluck('name', 'id')->toArray()
                                            : [];

                                            }

                                            )
                                   // ->placeholder($level ? 'Selecciona un objetivo' : 'Selecciona un nivel primero')
                                  //  ->disabled(!$level),
                                ]),


            ]);
    }
}
