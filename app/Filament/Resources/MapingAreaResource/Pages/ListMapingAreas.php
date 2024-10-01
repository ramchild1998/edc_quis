<?php

namespace App\Filament\Resources\MapingAreaResource\Pages;

use App\Filament\Resources\MapingAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMapingAreas extends ListRecords
{
    protected static string $resource = MapingAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
