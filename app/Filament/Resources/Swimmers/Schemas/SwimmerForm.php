<?php

namespace App\Filament\Resources\Swimmers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SwimmerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('skill_id')
                    ->numeric(),
                TextInput::make('group_id')
                    ->numeric(),
                TextInput::make('review'),

                TextInput::make('complement'),

            ]);
    }
}
