<?php

namespace App\Filament\Resources;

use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\VisitResource\Pages;
use App\Filament\Resources\VisitResource\RelationManagers;
use App\Models\MapingArea;
use App\Models\Visit;
use Closure;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function shouldRegisterNavigation(): bool
    {
    	return Filament::auth()->user()->can('Visit View');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make() ->schema([

                    // Forms\Components\TextInput::make('id_visit')
                    //     ->required()
                    //     ->maxLength(10),

                        Forms\Components\Section::make('AREA')
                        ->schema([
                            Forms\Components\Select::make('vendor_id')
                                ->relationship('vendor', 'vendor_name', fn(Builder $query) => $query->orderBy('vendor_name'))
                                ->required()
                                ->preload()
                                ->label('Vendor')
                                ->searchable()
                                ->placeholder('Pilih vendor'),
                            // Forms\Components\Select::make('area_id')
                            //     ->relationship('area', 'id')
                            //     ->required(),
                            // Forms\Components\Select::make('location_id')
                            //     ->relationship('location', 'id')
                            //     ->required(),


                            // Forms\Components\Select::make('area_id')
                            //     ->relationship('area', 'area_name', fn(Builder $query) => $query->orderBy('area_name'))
                            //     ->required()
                            //     ->reactive()  // Tambahkan reactive agar bisa memicu perubahan di Maping Area
                            //     ->afterStateUpdated(function (callable $set, $state) {
                            //         // Reset pilihan Maping Area saat Area berubah
                            //         $set('maping_area_id', null);
                            //     })
                            //     ->label('Area')
                            //     ->searchable()
                            //     ->preload()
                            //     ->placeholder('Pilih area'),
                            //     // ->hint('Pilih area terlebih dahulu')
                            //     // ->hintColor('danger')
                            //     // ->hintIcon('heroicon-o-information-circle'),

                            Forms\Components\Select::make('area_id')
                                ->relationship('area', 'area_name', fn(Builder $query) => $query->where('status', true)->orderBy('area_name'))
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('maping_area_id', null);
                                })
                                ->label('Area')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih area'),

                            Forms\Components\Select::make('maping_area_id')
                                ->label('Maping Area')
                                ->options(function (callable $get) {
                                    // Ambil ID Area yang dipilih
                                    $areaId = $get('area_id');

                                    // Pastikan area_id sudah dipilih
                                    if (!$areaId) {
                                        return [];
                                    }

                                    // Ambil data maping area yang sesuai dengan area_id
                                    return MapingArea::where('area_id', $areaId)  // Filter berdasarkan area_id yang dipilih
                                        ->get()
                                        ->mapWithKeys(function ($mapingArea) {
                                            // Gabungkan area_name dengan sub_area sebagai label
                                            return [
                                                $mapingArea->id => "{$mapingArea->area->area_name} -> {$mapingArea->sub_area}",
                                            ];
                                        });
                                })
                                ->required()
                                // ->preload()
                                ->searchable()
                                ->placeholder('Pilih location')
                                ->label('Location'),
                            Forms\Components\TextInput::make('nama_lokasi')
                                ->maxLength(100)
                                ->label('Nama Lokasi'),


                            Forms\Components\Select::make('keterangan_lokasi')
                                ->label('Keterangan Lokasi')
                                ->options([
                                    'Pertokoan' => 'Pertokoan',
                                    'Ruko' => 'Ruko',
                                    'Pasar' => 'Pasar',
                                    'Lainnya' => 'Lainnya',
                                ])
                                ->reactive()
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih keterangan lokasi'),
                            Forms\Components\TextInput::make('keterangan_lokasi_lainnya')
                                ->label('Opsi Keterangan Lokasi Lainnya')
                                ->placeholder('Masukkan opsi lainnya')
                                ->maxLength(22)
                                ->required(fn ($get) => $get('keterangan_lokasi') === 'Lainnya')
                                ->visible(fn ($get) => $get('keterangan_lokasi') === 'Lainnya'),
                            Forms\Components\TextInput::make('nama_usaha')
                                ->required()
                                ->maxLength(100)
                                ->label('Nama Usaha'),
                            Forms\Components\TextInput::make('alamat_usaha')
                                ->required()
                                ->maxLength(255)
                                ->label('Alamat Usaha'),
                            Forms\Components\Select::make('province_id')
                                ->relationship('province', 'province_name', fn(Builder $query) => $query->orderBy('province_name'))
                                ->preload()
                                ->required()
                                ->placeholder('Pilih provinsi')
                                ->reactive() // Menambahkan reactive
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('city_id', null); // Reset city_id
                                    $set('district_id', null); // Reset district_id
                                    $set('subdistrict_id', null); // Reset subdistrict_id
                                    $set('poscode_id', null); // Reset poscode_id
                                })
                                ->searchable()
                                ->label('Provinsi'),
                                // ->hint('Pilih provinsi terlebih dahulu')
                                // ->hintColor('danger')
                                // ->hintIcon('heroicon-o-information-circle'),
                            Forms\Components\Select::make('city_id')
                                ->relationship('city', 'city_name', function (Builder $query, $get) {
                                    $id = $get('province_id');
                                    $query->where('province_id', $id);
                                    $query->orderBy('city_name');
                                })
                                ->preload()
                                ->required()
                                ->placeholder('Pilih kota')
                                ->reactive() // Menambahkan reactive
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('district_id', null); // Reset district_id
                                    $set('subdistrict_id', null); // Reset subdistrict_id
                                    $set('poscode_id', null); // Reset poscode_id
                                })
                                ->searchable()
                                ->label('Kota'),
                            Forms\Components\Select::make('district_id')
                                ->relationship('district', 'district_name', function (Builder $query, $get) {
                                    $id = $get('city_id');
                                    $query->where('city_id', $id);
                                    $query->orderBy('district_name');
                                })
                                ->preload()
                                ->required()
                                ->placeholder('Pilih kecamatan')
                                ->reactive() // Menambahkan reactive
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('subdistrict_id', null); // Reset subdistrict_id
                                    $set('poscode_id', null); // Reset poscode_id
                                })
                                ->searchable()
                                ->label('Kecamatan'),
                            Forms\Components\Select::make('subdistrict_id')
                                ->relationship('subdistrict', 'subdistrict_name', function(Builder $query, $get) {
                                    $id = $get('district_id');
                                    $query->where('district_id', $id);
                                    $query->orderBy('subdistrict_name');
                                })
                                ->preload()
                                ->required()
                                ->placeholder('Pilih kelurahan')
                                ->reactive() // Menambahkan reactive
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('poscode_id', null); // Reset poscode_id
                                })
                                ->searchable()
                                ->label('Kelurahan'),
                            Forms\Components\Select::make('poscode_id')
                                ->relationship('poscode', 'poscode', function(Builder $query, $get) {
                                    $id = $get('subdistrict_id');
                                    $query->where('subdistrict_id', $id);
                                    $query->orderBy('poscode');
                                })
                                ->preload()
                                ->required()
                                ->placeholder('Pilih kode pos')
                                ->searchable()
                                ->label('Kode Pos'),
                            Forms\Components\Toggle::make('is_merchant')
                                ->label('Apakah Pemilik Terdaftar Sebagai Merchant BCA?')
                                ->reactive(),
                        ])
                        ->columns(1),

                    Forms\Components\Section::make('Informasi Merchant')
                    ->schema([

                        Forms\Components\TextInput::make('mid')
                        ->disabled(function($get){
                            return !$get('is_merchant');
                        })
                        ->label('MID')
                        ->maxLength(9)
                        ->label('MID')
                        ->hint('9 Digit')
                        ->placeholder('Contoh : 000123456')
                        ->helperText('Check MID terlebih dahulu!')
                        ->suffixAction(
                            Forms\Components\Actions\Action::make('check')
                                ->disabled(function($get){
                                    return !$get('is_merchant');
                                })
                                ->label('Check')
                                ->icon('heroicon-m-magnifying-glass')
                                ->action(function ($state, $livewire) {
                                    if (empty($state)) {
                                        Notification::make()
                                            ->title('MID belum diisi')
                                            ->body('Silakan isi MID terlebih dahulu.')
                                            ->warning()
                                            ->send();
                                        return;
                                    }

                                    // Logika untuk memeriksa MID
                                    $existingVisit = Visit::where('mid', $state)->first();
                                    if ($existingVisit) {
                                        Notification::make()
                                            ->title('MID sudah ada')
                                            ->body('MID ini sudah terdaftar dalam sistem.')
                                            ->danger()
                                            ->send();
                                    } else {
                                        Notification::make()
                                            ->title('MID tersedia')
                                            ->body('MID ini belum terdaftar dalam sistem.')
                                            ->success()
                                            ->send();
                                    }
                                })
                        ),

                        Forms\Components\TagsInput::make('tid')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->label('TID')
                            ->separator(',')
                            ->splitKeys(['Tab', 'Enter', ','])
                            ->placeholder('Masukkan TID dan tekan Enter atau Tab')
                            ->columnSpanFull()
                            ->helperText('Masukkan beberapa TID. Setiap TID maksimal 8 digit. Contoh: C0141271 (Enter/Tab untuk setiap TID)')
                            ->rules(['max:8']),

                        Forms\Components\TextInput::make('nomor_sn')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->placeholder('Contoh : 12A1B1C1234')
                            ->label('Nomor SN')
                            ->maxLength(24),
                        Forms\Components\TextInput::make('nama_pemilik')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Nama Pemilik Usaha/Rekening')
                            ->maxLength(45),
                        Forms\Components\TextInput::make('no_kontak')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('No. Kontak Pemilik Usaha/PIC Toko')
                            ->maxLength(20)
                            ->placeholder('Contoh : 081234567890'),
                        Forms\Components\Select::make('alamat_edc_sesuai')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Apakah Alamat Edc Sesuai?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),
                        Forms\Components\Select::make('ada_edc_bca')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Apakah Ada EDC BCA?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),
                        Forms\Components\TextInput::make('jumlah_edc')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Jumlah EDC')
                            ->placeholder('Contoh : 1')
                            ->numeric(),


                        Forms\Components\Select::make('edc_bank_lain')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Apakah Ada EDC Bank Lain?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ])
                            ->reactive(),
                        Forms\Components\CheckboxList::make('list_edc_bank_lain')
                            ->options([
                                'Mandiri' => 'Mandiri',
                                'BRI' => 'BRI',
                                'BTN' => 'BTN',
                                'Shopee' => 'Shopee',
                                'MTI' => 'MTI',
                                'PVS' => 'PVS',
                                'Lainnya' => 'Lainnya',  // Opsi Lainnya hanya untuk menampilkan TextInput
                            ])
                            ->disabled(function($get){
                                return !$get('is_merchant') || $get('edc_bank_lain') == 0;
                            })
                            ->required(function($get){
                                return $get('is_merchant') && $get('edc_bank_lain') == 1;
                            })
                            ->label('List EDC Bank Lain')
                            ->columnSpanFull()
                            ->visible(function($get){
                                return $get('edc_bank_lain') == 1;
                            })
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $get, $state) {
                                // Jika "Lainnya" di-uncheck, kosongkan field 'list_edc_bank_lain_lainnya'
                                if (!in_array('Lainnya', $state ?? [])) {
                                    $set('list_edc_bank_lain_lainnya', null); // Reset 'list_edc_bank_lain_lainnya' jika "Lainnya" tidak dicentang
                                }
                            }),
                        Forms\Components\TextInput::make('list_edc_bank_lain_lainnya')
                            ->label('EDC Bank Lain (Lainnya)')
                            ->maxLength(255)
                            ->visible(function($get) {
                                // Tampilkan TextInput hanya jika opsi "Lainnya" dicentang
                                return $get('edc_bank_lain') == 1 && in_array('Lainnya', $get('list_edc_bank_lain') ?? []);
                            })
                            ->required(function($get) {
                                return $get('edc_bank_lain') == 1 && in_array('Lainnya', $get('list_edc_bank_lain') ?? []) && $get('is_merchant');
                            })
                            ->afterStateUpdated(function (callable $set, $get, $state) {
                                // Ambil nilai 'list_edc_bank_lain' yang ada kecuali 'Lainnya'
                                $edcBankLain = array_diff($get('list_edc_bank_lain') ?? [], ['Lainnya']);

                                // Jika ada nilai yang diisi dalam TextInput "Lainnya"
                                if ($state) {
                                    // Tambahkan nilai input dari TextInput ke array opsi yang ada
                                    $edcBankLain[] = $state;
                                }

                                // Set ulang nilai dari 'list_edc_bank_lain' tanpa menyertakan "Lainnya"
                                $set('list_edc_bank_lain', $edcBankLain);
                            }),


                        Forms\Components\Select::make('catatan_kunjungan_edc')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->reactive()
                            ->options([
                                'Mandiri' => 'Mandiri',
                                'BRI' => 'BRI',
                                'BNI' => 'BNI',
                                'BTN' => 'BTN',
                                'Shopee' => 'Shopee',
                                'MTI' => 'MTI',
                                'PVS' => 'PVS',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->label('EDC utama yang digunakan'),


                        Forms\Components\TextInput::make('utama_lainnya')
                            ->label('EDC utama yang digunakan lainnya')
                            ->maxLength(22)
                            ->visible(function($get){
                                return $get('catatan_kunjungan_edc') === 'Lainnya';
                            })
                            ->required(function($get){
                                return $get('catatan_kunjungan_edc') === 'Lainnya' && $get('is_merchant');
                            })
                            ->disabled(function($get){
                                return $get('catatan_kunjungan_edc') !== 'Lainnya';
                            }),
                        Forms\Components\Select::make('qris_bca')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Qris BCA?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),
                        Forms\Components\TextInput::make('nmid')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->label('NMID')
                            ->maxLength(15),
                        Forms\Components\Textarea::make('list_qris_bank_lain')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->label('List Qris Bank Lain')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('tes_transaksi')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Apakah Berhasil Tes Transaksi?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),
                        Forms\Components\Textarea::make('catatan_kunjungan_program')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->label('Catatan Kunjungan - Program bank lain')
                            ->maxLength(50),
                        Forms\Components\Textarea::make('kendala')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->label('Kendala')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('request')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->label('Request')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('jumlah_struk')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->label('Jumlah Struk Diberikan')
                            ->numeric(),
                        Forms\Components\TextInput::make('id_lapor_halo')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->label('ID Lapor Halo')
                            ->maxLength(8),
                    ])->columns(1)->hidden(fn ($get) => !$get('is_merchant')),

                    Forms\Components\Section::make('Informasi Merchant Potensial')
                    ->schema([
                        Forms\Components\Select::make('pengajuan_merchant')
                            ->disabled(function($get){
                                return $get('is_merchant');
                            })
                            ->required(function ($get){
                                return !$get('is_merchant');
                            })
                            ->reactive()
                            ->placeholder('Pilih opsi')
                            ->options([
                                "Yes" => 'Yes',
                                "No" => 'No',
                                "Perlu Konfirmasi Owner" => 'Perlu Konfirmasi Owner',
                            ])
                            ->label('Pengajuan Merchant'),


                        Forms\Components\Select::make('aplikasi_pendaftaran')
                            ->required(function ($get){
                                return $get('pengajuan_merchant') === 'Yes' && !$get('is_merchant');
                            })
                            ->disabled(function($get){
                                return $get('is_merchant');
                            })
                            ->placeholder('Pilih aplikasi pendaftaran')
                            ->options([
                                "FDM" => 'FDM',
                                "Merchant App" => 'Merchant App',
                            ])
                            ->label('Aplikasi Pendaftaran')
                            ->reactive(),
                        Forms\Components\TextInput::make('fdm_id')
                            ->disabled(function($get){
                                return $get('is_merchant');
                            })
                            ->label('FDM ID')
                            ->maxLength(7)
                            ->hidden(function($get){
                                return $get('aplikasi_pendaftaran') === 'Merchant App';
                            }),


                        Forms\Components\Textarea::make('alasan_tidak_bersedia')
                            ->required(function ($get){
                                return $get('pengajuan_merchant') === 'No' && !$get('is_merchant');
                            })
                            ->disabled(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Alasan Tidak Bersedia')
                            ->maxLength(50),
                        Forms\Components\Select::make('mempunyai_edc')
                            ->required(function ($get){
                                return !$get('is_merchant');
                            })
                            ->disabled(function($get){
                                return $get('is_merchant');
                            })
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ])
                            ->label('Mempunyai EDC BCA Sebelumnya'),
                        Forms\Components\Textarea::make('keterangan_lain')
                            ->disabled(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Keterangan Lain')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('nomor_referensi')
                            ->disabled(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Nomor Referensi')
                            ->maxLength(255),
                    ])->columns(1)->hidden(fn ($get) => $get('is_merchant')),

                    Forms\Components\Section::make('Bukti Kunjungan')
                        ->schema([

                        Forms\Components\FileUpload::make('foto_struk')
                            // ->required()
                            ->image()
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userName = str_replace(' ', '_', Auth::user()->name); // Ganti spasi dengan underscore
                                return 'foto_struk_' . $userName . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Struk Transaksi'),

                        Forms\Components\FileUpload::make('foto_tampak_depan')
                            // ->required()
                            ->image()
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userName = str_replace(' ', '_', Auth::user()->name);
                                return 'foto_tampak_depan_' . $userName . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Tampak Depan'),

                        Forms\Components\FileUpload::make('foto_meja_kasir')
                            // ->required()
                            ->image()
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userName = str_replace(' ', '_', Auth::user()->name);
                                return 'foto_meja_kasir_' . $userName . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Meja Kasir (Terlihat EDC/QRIS)'),

                        Forms\Components\FileUpload::make('foto_qris_statis')
                            // ->required()
                            ->image()
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userName = str_replace(' ', '_', Auth::user()->name);
                                return 'foto_qris_statis_' . $userName . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto QRIS Statis'),

                        Forms\Components\FileUpload::make('foto_selfie')
                            // ->required()
                            ->image()
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userName = str_replace(' ', '_', Auth::user()->name);
                                return 'foto_selfie_' . $userName . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Selfie Dengan Pemilik Usaha/PIC Toko'),

                        Forms\Components\FileUpload::make('foto_produk')
                            // ->required()
                            ->image()
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userName = str_replace(' ', '_', Auth::user()->name);
                                return 'foto_produk_' . $userName . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Produk di Merchant'),

                        Forms\Components\FileUpload::make('screen_capture')
                            // ->required()
                            ->image()
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userName = str_replace(' ', '_', Auth::user()->name);
                                return 'screen_capture_' . $userName . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Screen Capture Laporan ke Halo BCA'),
                            Forms\Components\TextInput::make('nama_surveyor')
                                ->required()
                                ->default(auth()->user()->name)
                                ->readOnly()
                                ->label('Nama Surveyor'),
                            Forms\Components\TextInput::make('upline1')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('sales_code')
                                ->maxLength(15)
                                ->label('Sales Code'),
                    ])->columns(1),

                    // Forms\Components\TextInput::make('lat')
                    //     ->numeric(),
                    // Forms\Components\TextInput::make('long')
                    //     ->numeric(),
                    // Forms\Components\TextInput::make('created_by')
                    //     ->required()
                    //     ->numeric(),
                    // Forms\Components\TextInput::make('updated_by')
                    //     ->required()
                    //     ->numeric(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_visit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vendor.id')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('area_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('location_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('area.area_name')
                    ->label('Area')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mapingArea.sub_area')
                    ->label('Maping Area')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan_lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_usaha')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_usaha')
                    ->searchable(),
                Tables\Columns\TextColumn::make('province.province_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.city_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('district.district_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subdistrict.subdistrict_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('poscode.poscode')
                    ->sortable(),
                Tables\Columns\TextColumn::make('mid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_sn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pemilik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_edc_sesuai')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    }),
                Tables\Columns\TextColumn::make('ada_edc_bca')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    }),
                Tables\Columns\TextColumn::make('jumlah_edc')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('edc_bank_lain')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    }),
                Tables\Columns\TextColumn::make('catatan_kunjungan_edc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qris_bca')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    }),
                Tables\Columns\TextColumn::make('nmid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tes_transaksi')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    }),
                Tables\Columns\TextColumn::make('catatan_kunjungan_program')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_struk')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_lapor_halo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pengajuan_merchant')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aplikasi_pendaftaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fdm_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alasan_tidak_bersedia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mempunyai_edc')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    }),
                Tables\Columns\TextColumn::make('keterangan_lain')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_referensi')
                    ->searchable(),

                // FOTO
                Tables\Columns\ImageColumn::make('foto_struk')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto_tampak_depan')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto_meja_kasir')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto_qris_statis')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto_selfie')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto_produk')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('screen_capture')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_submit')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_submit'),
                Tables\Columns\TextColumn::make('nama_surveyor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('upline1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('long')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updatedBy.name')
                    ->label('Updated By')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisits::route('/'),
            'create' => Pages\CreateVisit::route('/create'),
            'edit' => Pages\EditVisit::route('/{record}/edit'),
        ];
    }
}
