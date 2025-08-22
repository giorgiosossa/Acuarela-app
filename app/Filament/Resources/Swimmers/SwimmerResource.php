<?php

namespace App\Filament\Resources\Swimmers;

use App\Filament\Resources\Swimmers\Pages\CreateSwimmer;
use App\Filament\Resources\Swimmers\Pages\EditSwimmer;
use App\Filament\Resources\Swimmers\Pages\ListSwimmers;
use App\Filament\Resources\Swimmers\Schemas\SwimmerForm;
use App\Filament\Resources\Swimmers\Tables\SwimmersTable;
use App\Models\Swimmer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SwimmerResource extends Resource
{
    protected static ?string $model = Swimmer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Swimmer';

    public static function form(Schema $schema): Schema
    {
        return SwimmerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SwimmersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSwimmers::route('/'),
            'create' => CreateSwimmer::route('/create'),
            'edit' => EditSwimmer::route('/{record}/edit'),
        ];
    }
}
