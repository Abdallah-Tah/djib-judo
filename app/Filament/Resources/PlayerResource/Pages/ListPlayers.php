<?php

namespace App\Filament\Resources\PlayerResource\Pages;

use App\Filament\Resources\PlayerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlayers extends ListRecords
{
    protected static string $resource = PlayerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
