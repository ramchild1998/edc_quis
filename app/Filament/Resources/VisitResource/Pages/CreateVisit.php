<?php

namespace App\Filament\Resources\VisitResource\Pages;

use App\Filament\Resources\VisitResource;
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
        $nextOrderNumber = $lastOrder ? intval(substr($lastOrder->id_visit, 4)) + 1 : 1;

        // Format order_id: "tahunbulan" + nextOrderNumber dengan padding 6 digit
        $data['id_visit'] = $tahun . $bulan . str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        $data['tanggal_submit'] = Carbon::today();
        // $data['tanggal_submit'] = Carbon::now()->addMonth()->startOfMonth();
        $data['waktu_submit'] = Carbon::now()->format('H:i:s');

        // Data MID tidak boleh sama, dan dalam 1 bulan data 1 record MID hanya boleh 1 kali, jika sudah ada maka tidak bisa ditambahkan
        // $existingMID = Visit::where('mid', $data['mid'])
        //     ->whereYear('tanggal_submit', Carbon::now()->year)
        //     ->whereMonth('tanggal_submit', Carbon::now()->month)
        //     ->exists();

        // if ($existingMID) {
        //     throw new \Exception('MID sudah ada dalam bulan ini. Tidak dapat menambahkan data baru.');
        // }

        if($data['keterangan_lokasi'] === 'Lainnya'){
            $data['keterangan_lokasi'] = $data['keterangan_lokasi_lainnya'];
        }
        if($data['catatan_kunjungan_edc'] === 'Lainnya'){
            $data['catatan_kunjungan_edc'] = $data['utama_lainnya'];
        }

        // Konversi array menjadi string untuk kolom yang menyimpan multiple values
        if (isset($data['tid']) && is_array($data['tid'])) {
            $data['tid'] = implode(',', $data['tid']);
        }
        if (isset($data['list_edc_bank_lain']) && is_array($data['list_edc_bank_lain'])) {
            $data['list_edc_bank_lain'] = implode(',', $data['list_edc_bank_lain']);
        }
        if (isset($data['list_qris_bank_lain']) && is_array($data['list_qris_bank_lain'])) {
            $data['list_qris_bank_lain'] = implode(',', $data['list_qris_bank_lain']);
        }
        if (isset($data['kendala']) && is_array($data['kendala'])) {
            $data['kendala'] = implode(',', $data['kendala']);
        }
        if (isset($data['request']) && is_array($data['request'])) {
            $data['request'] = implode(',', $data['request']);
        }

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
