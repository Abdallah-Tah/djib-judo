<?php

namespace App\Filament\Resources\PlayerResource\Pages;

use App\Filament\Resources\PlayerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePlayer extends CreateRecord
{
    protected static string $resource = PlayerResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
