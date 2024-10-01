<?php

namespace App\Filament\Resources\MapingAreaResource\Pages;

use App\Filament\Resources\MapingAreaResource;
use Filament\Actions;
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
}
