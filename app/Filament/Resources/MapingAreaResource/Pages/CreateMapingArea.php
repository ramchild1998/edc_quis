<?php

namespace App\Filament\Resources\MapingAreaResource\Pages;

use App\Filament\Resources\MapingAreaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMapingArea extends CreateRecord
{
    protected static string $resource = MapingAreaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Maping Area Create')
            ->body('The maping area has been created successfully.');
    }
}
