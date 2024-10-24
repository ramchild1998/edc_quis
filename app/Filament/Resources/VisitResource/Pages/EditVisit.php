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

        $knownBanks = ['Mandiri', 'BRI', 'BNI', 'BTN', 'Shopee', 'MTI', 'PVS'];
        if (isset($data['list_edc_bank_lain']) && is_string($data['list_edc_bank_lain'])) {
            $data['list_edc_bank_lain'] = explode(',', $data['list_edc_bank_lain']);

            $otherValues = array_diff($data['list_edc_bank_lain'], $knownBanks);

            if (!empty($otherValues)) {
                $data['list_edc_bank_lain'][] = 'Lainnya';
                $data['list_edc_bank_lain_lainnya'] = implode(', ', $otherValues);
            } else {
                $data['list_edc_bank_lain_lainnya'] = '';
            }
        }
        if (isset($data['list_qris_bank_lain']) && is_string($data['list_qris_bank_lain'])) {
            $data['list_qris_bank_lain'] = explode(',', $data['list_qris_bank_lain']);

            $otherValues = array_diff($data['list_qris_bank_lain'], $knownBanks);

            if (!empty($otherValues)) {
                $data['list_qris_bank_lain'][] = 'Lainnya';
                $data['list_qris_bank_lain_lainnya'] = implode(', ', $otherValues);
            } else {
                $data['list_qris_bank_lain_lainnya'] = '';
            }
        }

        if (isset($data['kendala']) && is_string($data['kendala'])) {
            $data['kendala'] = explode(',', $data['kendala']);

            $knownKendala = ['Jaringan', 'Baterai', 'Adaptor', 'Tombol', 'Printer'];
            $otherKendala = array_diff($data['kendala'], $knownKendala);

            if (!empty($otherKendala)) {
                $data['kendala'] = array_diff($data['kendala'], ['Lainnya']);
                $data['kendala'][] = 'Lainnya';
                $data['kendala_lainnya'] = implode(', ', $otherKendala);
            } else {
                $data['kendala_lainnya'] = '';
            }
        }

        if (isset($data['request']) && is_string($data['request'])) {
            $data['request'] = explode(',', $data['request']);

            $knownRequests = ['Tambah Fasilitas', 'Ganti APOS', 'Tambah Edisi', 'Tambah Terminal', 'Request Struk', 'Perubahan Data'];
            $otherRequests = array_diff($data['request'], $knownRequests);

            if (!empty($otherRequests)) {
                $data['request'] = array_diff($data['request'], ['Lainnya']);
                $data['request'][] = 'Lainnya';
                $data['request_lainnya'] = implode(', ', $otherRequests);
            } else {
                $data['request_lainnya'] = '';
            }
        }


        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['tid']) && is_array($data['tid'])) {
            $data['tid'] = implode(',', $data['tid']);
        }

        if (isset($data['list_edc_bank_lain']) && is_array($data['list_edc_bank_lain'])) {
            $tempArr = $data['list_edc_bank_lain'];
            $key = array_search('Lainnya', $tempArr);
            if($key !== false){
                $tempArr[$key] = $data['list_edc_bank_lain_lainnya'];
            }
            $data['list_edc_bank_lain'] = implode(',', array_unique($tempArr));
        }

        if (isset($data['list_qris_bank_lain']) && is_array($data['list_qris_bank_lain'])) {
            $tempArr = $data['list_qris_bank_lain'];
            $key = array_search('Lainnya', $tempArr);
            if($key !== false){
                $tempArr[$key] = $data['list_qris_bank_lain_lainnya'];
            }
            $data['list_qris_bank_lain'] = implode(',', array_unique($tempArr));
        }

        if (isset($data['kendala']) && is_array($data['kendala'])) {
            $tempArr = $data['kendala'];
            $key = array_search('Lainnya', $tempArr);
            if($key !== false){
                $tempArr[$key] = $data['kendala_lainnya'];
            }
            $data['kendala'] = implode(',', array_unique($tempArr));
        }

        if (isset($data['request']) && is_array($data['request'])) {
            $tempArr = $data['request'];
            $key = array_search('Lainnya', $tempArr);
            if($key !== false){
                $tempArr[$key] = $data['request_lainnya'];
            }
            $data['request'] = implode(',', array_unique($tempArr));
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
