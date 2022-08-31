<?php

namespace App\Filament\Resources\ClubResource\Pages;

use App\Filament\Resources\ClubResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClub extends CreateRecord
{
    protected static string $resource = ClubResource::class;

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
