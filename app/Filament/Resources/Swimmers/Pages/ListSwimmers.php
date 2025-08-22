<?php

namespace App\Filament\Resources\Swimmers\Pages;

use App\Filament\Resources\Swimmers\SwimmerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSwimmers extends ListRecords
{
    protected static string $resource = SwimmerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
