<?php

namespace App\Filament\Resources\MapingAreaResource\Pages;

use App\Filament\Resources\MapingAreaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMapingArea extends EditRecord
{
    protected static string $resource = MapingAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Maping Area Edited')
            ->body('The maping area has been edited successfully.');
    }
}
