<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('hour')
                    ->required(),
                TextInput::make('days')
                    ->required(),
                TextInput::make('note')
                    ->required(),
                TextInput::make('level_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
