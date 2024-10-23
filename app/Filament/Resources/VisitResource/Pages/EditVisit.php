<?php

namespace App\Filament\Resources\VisitResource\Pages;

use App\Filament\Resources\VisitResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditVisit extends EditRecord
{
    protected static string $resource = VisitResource::class;

    // Konversi data sebelum form diisi
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['tid']) && is_string($data['tid'])) {
            $data['tid'] = explode(',', $data['tid']); // Konversi string menjadi array dengan pemisah koma
        }

        if (isset($data['list_edc_bank_lain']) && is_string($data['list_edc_bank_lain'])) {
            $data['list_edc_bank_lain'] = explode(',', $data['list_edc_bank_lain']);
            // Cek apakah 'Lainnya' ada dalam list_edc_bank_lain
            if (in_array('Lainnya', $data['list_edc_bank_lain'])) {
                $data['list_edc_bank_lain_lainnya'] = $data['list_edc_bank_lain_lainnya'] ?? '';
            }
        }

        // Handle list_qris_bank_lain
        if (isset($data['list_qris_bank_lain']) && is_string($data['list_qris_bank_lain'])) {
            $data['list_qris_bank_lain'] = explode(',', $data['list_qris_bank_lain']);
            if (in_array('Lainnya', $data['list_qris_bank_lain'])) {
                // Jika 'Lainnya' dipilih, pastikan field lainnya diisi sesuai value dari database
                $data['list_qris_bank_lain_lainnya'] = $data['list_qris_bank_lain_lainnya'] ?? '';
            }
        }

        if (isset($data['kendala']) && is_string($data['kendala'])) {
            $data['kendala'] = explode(',', $data['kendala']); // Konversi string menjadi array
        }

        if (isset($data['request']) && is_string($data['request'])) {
            $data['request'] = explode(',', $data['request']); // Konversi string menjadi array
        }


        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['tid']) && is_array($data['tid'])) {
            $data['tid'] = implode(',', $data['tid']);
        }

        if (isset($data['list_edc_bank_lain']) && is_array($data['list_edc_bank_lain'])) {
            $data['list_edc_bank_lain'] = implode(',', $data['list_edc_bank_lain']);
            // Jika 'Lainnya' ada, pastikan untuk menyimpan nilai lainnya
            if (in_array('Lainnya', $data['list_edc_bank_lain'])) {
                $data['list_edc_bank_lain_lainnya'] = $data['list_edc_bank_lain_lainnya'] ?? '';
            }
        }

        // Handle list_qris_bank_lain
        if (isset($data['list_qris_bank_lain']) && is_array($data['list_qris_bank_lain'])) {
            $data['list_qris_bank_lain'] = implode(',', $data['list_qris_bank_lain']);
            if (in_array('Lainnya', $data['list_qris_bank_lain'])) {
                // Pastikan field lainnya tetap tersimpan jika 'Lainnya' dipilih
                $data['list_qris_bank_lain_lainnya'] = $data['list_qris_bank_lain_lainnya'] ?? '';
            } else {
                // Hapus field lainnya jika 'Lainnya' tidak dipilih
                $data['list_qris_bank_lain_lainnya'] = null;
            }
        }

        if (isset($data['kendala']) && is_array($data['kendala'])) {
            $data['kendala'] = implode(',', $data['kendala']); // Konversi array menjadi string
        }

        if (isset($data['request']) && is_array($data['request'])) {
            $data['request'] = implode(',', $data['request']); // Konversi array menjadi string
        }


        $data['updated_by'] = auth()->id();
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Visit Edited')
            ->body('The visit has been edited successfully.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
