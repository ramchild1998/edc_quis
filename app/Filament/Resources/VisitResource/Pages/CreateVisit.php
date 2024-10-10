<?php

namespace App\Filament\Resources\VisitResource\Pages;

use App\Filament\Resources\VisitResource;
use App\Models\Visit;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateVisit extends CreateRecord
{
    protected static string $resource = VisitResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tahun = date('y'); // Dua digit tahun (misal: 24)
        $bulan = date('m'); // Dua digit bulan (misal: 10)

        // Ambil order_id terakhir yang mengikuti format tahun dan bulan saat ini
        $lastOrder = Visit::where('order_id', 'like', $tahun . $bulan . '%')
            ->orderBy('order_id', 'desc')
            ->first();

        // Jika ada order_id, ambil 6 digit terakhir dan tambahkan 1, jika tidak ada, mulai dari 1
        $nextOrderNumber = $lastOrder ? intval(substr($lastOrder->order_id, 4)) + 1 : 1;

        // Format order_id: "tahunbulan" + nextOrderNumber dengan padding 6 digit
        $data['order_id'] = $tahun . $bulan . str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        \Log::info('Generated Order ID: ' . $data['order_id']); // Log generated Order ID
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        $data['status'] = true;
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Visit Create')
            ->body('The visit has been created successfully.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
