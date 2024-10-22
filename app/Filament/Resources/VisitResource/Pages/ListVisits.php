<?php

namespace App\Filament\Resources\VisitResource\Pages;

use App\Filament\Resources\VisitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListVisits extends ListRecords
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            ExportAction::make()->exports([
                    ExcelExport::make()->withColumns([
                            Column::make("vendor.vendor_name")->heading("Vendor"),
                            Column::make("area.id_area")->heading("Area ID"),
                            Column::make("location.id_lokasi")->heading("Location ID"),
                            Column::make("nama_lokasi")->heading("Nama Lokasi"),
                            Column::make("keterangan_lokasi")->heading("Keterangan Lokasi"),
                            Column::make("nama_usaha")->heading("Nama Usaha"),
                            Column::make("alamat_usaha")->heading("Alamat Usaha"),
                            Column::make("province.province_name")->heading("Provinsi"),
                            Column::make("city.city_name")->heading("Kota"),
                            Column::make("district.district_name")->heading("Kecamatan"),
                            Column::make("subdistrict.subdistrict_name")->heading("Kelurahan"),
                            Column::make("poscode.poscode")->heading("Kode Pos"),

                            Column::make("mid")->heading("MID"),
                            Column::make("tid")->heading("TID"),
                            Column::make("nomor_sn")->heading("Nomor SN"),
                            Column::make("nama_pemilik")->heading("Nama Pemilik Usaha/Rekening"),
                            Column::make("no_kontak")->heading("Nomor Kontak Pemilik Usaha/PIC Toko"),
                            Column::make("alamat_edc_sesuai")->heading("Alamat EDC Sesuai?"),
                            Column::make("ada_edc_bca")->heading("Apakah Ada EDC BCA Atau Tidak?"),
                            Column::make("jumlah_edc")->heading("Jumlah EDC"),
                            Column::make("edc_bank_lain")->heading("EDC Bank Lain"),
                            Column::make("list_edc_bank_lain")->heading("List EDC Bank Lain"),
                            Column::make("catatan_kunjungan_edc")->heading("Catatan Kunjungan - EDC Utama Yang Digunakan"),
                            Column::make("qris_bca")->heading("QRIS BCA"),
                            Column::make("nmid")->heading("NMID"),
                            Column::make("list_qris_bank_lain")->heading("List QRIS Bank Lain"),
                            Column::make("tes_transaksi")->heading("Berhasil Tes Transaksi"),
                            Column::make("catatan_kunjungan_program")->heading("Catatan Kunjungan - Program Bank Lain"),
                            Column::make("kendala")->heading("Kendala"),
                            Column::make("request")->heading("Request"),
                            Column::make("jumlah_struk")->heading("Jumlah Struk Diberikan"),
                            Column::make("id_lapor_halo")->heading("ID Lapor HALO"),

                            Column::make("pengajuan_merchant")->heading("Pengajuan Merchant BCA"),
                            Column::make("aplikasi_pendaftaran")->heading("Aplikasi Pendaftaran"),
                            Column::make("fdm_id")->heading("FDM ID"),
                            Column::make("alasan_tidak_bersedia")->heading("Alasan Tidak Bersedia"),
                            Column::make("mempunyai_edc")->heading("Mempunyai EDC BCA Sebelumnya"),
                            Column::make("keterangan_lain")->heading("Keterangan Lain"),
                            Column::make("nomor_referensi")->heading("Nomor Referensi Pengajuan Merchant Baru"),

                            Column::make("foto_struk")->heading("Foto Struk Transaksi")
                                ->formatStateUsing(fn ($record) => "http://147.79.74.76/storage" . $record->foto_struk),
                            Column::make("foto_tampak_depan")->heading("Foto Tampak Depan")
                                ->formatStateUsing(fn ($record) => "http://147.79.74.76/storage" . $record->foto_tampak_depan),
                            Column::make("foto_meja_kasir")->heading("Foto Meja Kasir")
                                ->formatStateUsing(fn ($record) => "http://147.79.74.76/storage" . $record->foto_meja_kasir),
                            Column::make("foto_qris_statis")->heading("Foto QRIS Statis")
                                ->formatStateUsing(fn ($record) => "http://147.79.74.76/storage" . $record->foto_qris_statis),
                            Column::make("foto_selfie")->heading("Foto Selfie Dengan Pemilik Usaha/PIC Toko")
                                ->formatStateUsing(fn ($record) => "http://147.79.74.76/storage" . $record->foto_selfie),
                            Column::make("foto_produk")->heading("Foto Produk di Merchant")
                                ->formatStateUsing(fn ($record) => "http://147.79.74.76/storage" . $record->foto_produk),
                            Column::make("screen_capture")->heading("Screen Capture Laporan ke Halo BCA")
                                ->formatStateUsing(fn ($record) => "http://147.79.74.76/storage" . $record->screen_capture),
                            Column::make("tanggal_submit")->heading("Tanggal Submit"),
                            Column::make("waktu_submit")->heading("Waktu Submit"),
                            Column::make("nama_surveyor")->heading("Nama Surveyor"),
                            Column::make("upline1")->heading("Upline 1"),
                            Column::make("sales_code")->heading("Sales Code"),
                            Column::make("lat")->heading("lat"),
                            Column::make("long")->heading("long"),
                        ])
                ])
                ->visible(fn () => auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMATS') || auth()->user()->hasRole('ADMBANK')),
        ];
    }
}
