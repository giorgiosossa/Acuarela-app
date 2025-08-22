<?php

namespace App\Filament\Resources\Swimmers\Pages;

use App\Filament\Resources\Swimmers\SwimmerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSwimmer extends EditRecord
{
    protected static string $resource = SwimmerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
