<?php

namespace App\Filament\Resources\OfficeResource\Pages;

use App\Filament\Resources\OfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditOffice extends EditRecord
{
    protected static string $resource = OfficeResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $data['updated_by'] = auth()->id();
        $record->update($data);

        return $record;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by'] = auth()->id();
        return $data;
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
