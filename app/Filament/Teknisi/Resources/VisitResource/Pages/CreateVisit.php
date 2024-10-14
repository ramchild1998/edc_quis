<?php

namespace App\Filament\Teknisi\Resources\VisitResource\Pages;

use App\Filament\Teknisi\Resources\VisitResource;
use App\Models\Visit;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateVisit extends CreateRecord
{
    protected static string $resource = VisitResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tahun = date('y'); // Dua digit tahun (misal: 24)
        $bulan = date('m'); // Dua digit bulan (misal: 10)

        // Ambil order_id terakhir yang mengikuti format tahun dan bulan saat ini
        $lastOrder = Visit::where('id_visit', 'like', $tahun . $bulan . '%')
            ->orderBy('id_visit', 'desc')
            ->first();

        // Jika ada order_id, ambil 6 digit terakhir dan tambahkan 1, jika tidak ada, mulai dari 1
        $nextOrderNumber = $lastOrder ? intval(substr($lastOrder->order_id, 4)) + 1 : 1;

        // Format order_id: "tahunbulan" + nextOrderNumber dengan padding 6 digit
        $data['id_visit'] = $tahun . $bulan . str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        $data['tanggal_submit'] = Carbon::today();
        $data['time_submit'] = Carbon::now()->format('H:i:s');

        // Temporary hardcode lat long to 0
        $data['lat'] = 0;
        $data['long'] = 0;
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Visit added')
            ->body('The visit has been created successfully.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
