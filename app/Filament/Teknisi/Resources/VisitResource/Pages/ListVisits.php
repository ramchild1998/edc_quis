<?php

namespace App\Filament\Teknisi\Resources\VisitResource\Pages;

use App\Filament\Teknisi\Resources\VisitResource;
use Closure;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisits extends ListRecords
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Override method ini untuk disable klik langsung pada record
    protected function getTableRecordAction(): ?string
    {
        return null;  // Disable link ke halaman edit saat klik record
    }
}
