<?php

namespace App\Filament\Resources;

use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\VisitResource\Pages;
use App\Filament\Resources\VisitResource\RelationManagers;
use App\Models\Location;
use App\Models\Visit;
use Carbon\Carbon;
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
use Illuminate\Validation\Rule;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


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
                                ->required()
                                ->label('Vendor')
                                ->options(\App\Models\Vendor::where('status', true)->pluck('vendor_name', 'id'))
                                ->default(function () {
                                    $dpiVendor = \App\Models\Vendor::where('vendor_name', 'DPI')->first();
                                    return $dpiVendor ? $dpiVendor->id : 1;
                                }),

                            Forms\Components\Select::make('area_id')
                                ->relationship('area', 'area_name', fn(Builder $query) => $query->where('status', true)->orderBy('area_name'))
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('location_id', null);
                                    $set('nama_lokasi', null);
                                })
                                ->label('Area ID')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih area'),

                            Forms\Components\Select::make('location_id')
                                ->options(function (callable $get) {
                                    // Ambil ID Area yang dipilih
                                    $areaId = $get('area_id');

                                    // Pastikan area_id sudah dipilih
                                    if (!$areaId) {
                                        return [];
                                    }

                                    // Ambil data maping area yang sesuai dengan area_id
                                    return Location::where('area_id', $areaId)  // Filter berdasarkan area_id yang dipilih
                                        ->get()
                                        ->mapWithKeys(function ($location) {
                                            // Gabungkan area_name dengan sub_area sebagai label
                                            return [
                                                $location->id => "{$location->area->area_name} -> {$location->lokasi}",
                                            ];
                                        });
                                })
                                ->required()
                                ->preload()
                                ->searchable()
                                ->placeholder('Pilih location')
                                ->label('Location ID')
                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Pilih Area ID terlebih dahulu!')
                                ->hintColor('primary')
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $get) {
                                    $locationId = $get('location_id');
                                    if ($locationId) {
                                        $location = Location::find($locationId);
                                        if ($location) {
                                            $set('nama_lokasi', $location->area->area_name . " " . $location->lokasi . " DPI");
                                        }
                                    }
                                }),
                            Forms\Components\TextInput::make('nama_lokasi')
                                ->maxLength(100)
                                ->label('Nama Lokasi')
                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Otomatis diperoleh dari Lokasi ID.')
                                ->hintColor('primary')
                                ->readOnly(),


                            Forms\Components\Select::make('keterangan_lokasi')
                                ->label('Keterangan Lokasi')
                                ->options([
                                    'Pertokoan' => 'Pertokoan',
                                    'Ruko' => 'Ruko',
                                    'Pasar' => 'Pasar',
                                    'Stand Alone' => 'Stand Alone',
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
                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Pilih provinsi terlebih dahulu!')
                                ->hintColor('primary')
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
                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Pilih kota terlebih dahulu!')
                                ->hintColor('primary')
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
                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Pilih kecamatan terlebih dahulu!')
                                ->hintColor('primary')
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
                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Pilih kelurahan terlebih dahulu!')
                                ->hintColor('primary')
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
                        ->rules(function ($get, $livewire) {
                            $recordId = optional($livewire->getRecord())->id; // Mendapatkan ID record yang sedang diedit atau null

                            return [
                                Rule::unique('visit', 'mid')
                                    ->where(function ($query) {
                                        $query->whereYear('id_visit', now()->year)
                                              ->whereMonth('id_visit', now()->month);
                                    })
                                    ->ignore($recordId), // Abaikan record yang sedang diedit
                            ];
                        })
                        ->maxLength(9)
                        ->label('MID')
                        ->hint('9 Digit')
                        ->placeholder('Contoh: 000123456')
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
                            ->rules(['max:8'])
                            ->formatStateUsing(fn ($state) => collect($state)->map(fn ($item) => strtoupper($item))->toArray())
                            ->formatStateUsing(fn ($state) => is_array($state) ? array_map('strtoupper', $state) : $state),

                        Forms\Components\TextInput::make('nomor_sn')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->placeholder('Contoh: 12A1B1C1234')
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
                            ->placeholder('Contoh: 081234567890'),
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
                            ->label('Apakah Ada EDC BCA atau Tidak?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ])
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state == 0) {
                                    $set('jumlah_edc', 0);
                                };
                            }),
                        Forms\Components\TextInput::make('jumlah_edc')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->readOnly(function($get){
                                return !$get('ada_edc_bca');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Jumlah EDC')
                            ->placeholder('Contoh: 1')
                            ->numeric()
                            ->minValue(function($get) {
                                return $get('ada_edc_bca') == 1 ? 1 : 0;
                            })
                            ->default(0)
                            ->rules([
                                function($get) {
                                    return function($attribute, $value, $fail) use ($get) {
                                        if ($get('ada_edc_bca') == 1 && $value < 1) {
                                            $fail("Jumlah EDC harus lebih dari 0 jika ada EDC BCA.");
                                        }
                                        if ($get('ada_edc_bca') == 0 && $value != 0) {
                                            $fail("Jumlah EDC harus 0 jika tidak ada EDC BCA.");
                                        }
                                    };
                                },
                            ])
                            ->reactive(),


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
                            ->maxLength(50)
                            ->visible(function($get) {
                                return $get('edc_bank_lain') == 1 && in_array('Lainnya', $get('list_edc_bank_lain') ?? []) && $get('is_merchant');
                            })
                            ->required(function($get) {
                                return $get('edc_bank_lain') == 1 && in_array('Lainnya', $get('list_edc_bank_lain') ?? []) && $get('is_merchant');
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
                            ->label('Catatan Kunjungan - EDC utama yang digunakan'),

                        Forms\Components\TextInput::make('utama_lainnya')
                            ->label('Catatan Kunjungan - EDC utama yang digunakan lainnya')
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
                            ->maxLength(15)
                            ->placeholder('ID1234567890123'),
                        Forms\Components\CheckboxList::make('list_qris_bank_lain')
                            ->disabled(function($get){
                                return !$get('is_merchant');
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
                            ->label('List Qris Bank Lain')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('list_qris_bank_lain_lainnya')
                            ->label('List Qris Bank Lain (Lainnya)')
                            ->maxLength(50)
                            ->visible(function($get) {
                                return in_array('Lainnya', $get('list_qris_bank_lain') ?? []) && $get('is_merchant');
                            })
                            ->disabled(function($get) {
                                return !in_array('Lainnya', $get('list_qris_bank_lain') ?? []) && !$get('is_merchant');
                            })
                            ->required(function($get) {
                                return in_array('Lainnya', $get('list_qris_bank_lain') ?? []) && $get('is_merchant');
                            }),
                        Forms\Components\Select::make('tes_transaksi')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->required(function($get){
                                return $get('is_merchant');
                            })
                            ->label('Berhasil Tes Transaksi')
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
                        Forms\Components\CheckboxList::make('kendala')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->reactive()
                            ->options([
                                'Jaringan' => 'Jaringan',
                                'Baterai' => 'Baterai',
                                'Adaptor' => 'Adaptor',
                                'Tombol' => 'Tombol',
                                'Printer' => 'Printer',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->label('Kendala')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('kendala_lainnya')
                            ->label('Kendala (Lainnya)')
                            ->maxLength(50)
                            ->visible(function($get) {
                                return in_array('Lainnya', $get('kendala') ?? []) && $get('is_merchant');
                            })
                            ->disabled(function($get) {
                                return !in_array('Lainnya', $get('kendala') ?? []) && !$get('is_merchant');
                            })
                            ->required(function($get) {
                                return in_array('Lainnya', $get('kendala') ?? []) && $get('is_merchant');
                            }),
                        Forms\Components\CheckboxList::make('request')
                            ->disabled(function($get){
                                return !$get('is_merchant');
                            })
                            ->reactive()
                            ->options([
                                'Tambah Fasilitas' => 'Tambah Fasilitas',
                                'Ganti APOS' => 'Ganti APOS',
                                'Tambah Edisi' => 'Tambah Edisi',
                                'Tambah Terminal' => 'Tambah Terminal',
                                'Request Struk' => 'Request Struk',
                                'Perubahan Data' => 'Perubahan Data',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->label('Request')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('request_lainnya')
                            ->label('Request (Lainnya)')
                            ->maxLength(50)
                            ->visible(function($get) {
                                return in_array('Lainnya', $get('request') ?? []) && $get('is_merchant');
                            })
                            ->disabled(function($get) {
                                return !in_array('Lainnya', $get('request') ?? []) && !$get('is_merchant');
                            })
                            ->required(function($get) {
                                return in_array('Lainnya', $get('request') ?? []) && $get('is_merchant');
                            }),
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
                            ->label('IDLaporHalo')
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
                            ->label('Pengajuan Merchant BCA'),


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
                            ->label('Nomor Referensi Pengajuan Merchant Baru')
                            ->maxLength(255),
                    ])->columns(1)->hidden(fn ($get) => $get('is_merchant')),

                    Forms\Components\Section::make('Bukti Kunjungan')
                        ->schema([

                        Forms\Components\FileUpload::make('foto_struk')
                            // ->required()
                            ->image()
                            ->optimize('jpg')
                            ->resize(50)
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userNip = str_replace(' ', '_', Auth::user()->nip); // Ganti spasi dengan underscore
                                return 'foto_struk_' . $userNip . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Struk Transaksi'),

                        Forms\Components\FileUpload::make('foto_tampak_depan')
                            // ->required()
                            ->image()
                            ->optimize('jpg')
                            ->resize(50)
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userNip = str_replace(' ', '_', Auth::user()->nip);
                                return 'foto_tampak_depan_' . $userNip . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Tampak Depan (Plang Nama)'),

                        Forms\Components\FileUpload::make('foto_meja_kasir')
                            // ->required()
                            ->image()
                            ->optimize('jpg')
                            ->resize(50)
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userNip = str_replace(' ', '_', Auth::user()->nip);
                                return 'foto_meja_kasir_' . $userNip . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Meja Kasir (Terlihat EDC/QRIS)'),

                        Forms\Components\FileUpload::make('foto_qris_statis')
                            // ->required()
                            ->image()
                            ->optimize('jpg')
                            ->resize(50)
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userNip = str_replace(' ', '_', Auth::user()->nip);
                                return 'foto_qris_statis_' . $userNip . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto QRIS Statis'),

                        Forms\Components\FileUpload::make('foto_selfie')
                            // ->required()
                            ->image()
                            ->optimize('jpg')
                            ->resize(50)
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userNip = str_replace(' ', '_', Auth::user()->nip);
                                return 'foto_selfie_' . $userNip . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Selfie Dengan Pemilik Usaha/PIC Toko'),

                        Forms\Components\FileUpload::make('foto_produk')
                            // ->required()
                            ->image()
                            ->optimize('jpg')
                            ->resize(50)
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            // ->maxSize(2 * 1024) // 2MB
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userNip = str_replace(' ', '_', Auth::user()->nip);
                                return 'foto_produk_' . $userNip . '_' . time() . '.' . $file->getClientOriginalExtension();
                            })
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                            ->hintColor('primary')
                            ->label('Foto Produk di Merchant'),

                        Forms\Components\FileUpload::make('screen_capture')
                            // ->required()
                            ->image()
                            ->optimize('jpg')
                            ->resize(50)
                            ->extraAttributes([
                                'accept' => 'image/*', // Membatasi hanya file gambar
                                'capture' => 'camera', // Membatasi hanya menggunakan kamera
                            ])
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $userNip = str_replace(' ', '_', Auth::user()->nip);
                                return 'screen_capture_' . $userNip . '_' . time() . '.' . $file->getClientOriginalExtension();
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

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_visit')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('vendor.vendor_name')
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('area_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('location_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('area.area_name')
                    ->label('Area')
                    ->formatStateUsing(function ($record){
                        return "{$record->area->id_area} => {$record->area->area_name}";
                    })
                    ->sortable()
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('location.lokasi')
                    ->label('Lokasi')
                    ->formatStateUsing(function ($record){
                        return "{$record->location->id_lokasi} => {$record->location->lokasi}";
                    })
                    ->sortable()
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('area.id_area')
                    ->label('Lokasi ID')
                    ->formatStateUsing(function ($record){
                        $idLokasi = $record->location->id_lokasi;
                        $idArea = $record->area->id_area;

                        return "L".$idArea.$idLokasi;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_lokasi')
                    ->label('Nama Lokasi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan_lokasi')
                    ->label('Keterangan Lokasi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_usaha')
                    ->label('Nama Usaha')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_usaha')
                    ->label('Alamat Usaha')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('province.province_name')
                    ->label('Provinsi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.city_name')
                    ->label('Kota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('district.district_name')
                    ->label('Kecamatan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subdistrict.subdistrict_name')
                    ->label('Kelurahan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('poscode.poscode')
                    ->label('Kode Pos')
                    ->sortable(),

                Tables\Columns\TextColumn::make('mid')
                    ->label('MID')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('tid')
                    ->label('TID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_sn')
                    ->label('Nomor SN')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return strtoupper($state);
                    }),
                Tables\Columns\TextColumn::make('nama_pemilik')
                    ->label('Nama Pemilik Usaha/Rekening')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_kontak')
                    ->label('Nomor Kontak Pemilik Usaha/PIC Toko')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat_edc_sesuai')
                    ->label('Alamat EDC Sesuai?')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('ada_edc_bca')
                    ->label('Apakah ada EDC BCA atau Tidak?')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_edc')
                    ->label('Jumlah EDC')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('edc_bank_lain')
                    ->label('EDC Bank Lain')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('list_edc_bank_lain')
                    ->label('List EDC Bank Lain')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('catatan_kunjungan_edc')
                    ->label('Catatan Kunjungan - EDC utama yang digunakan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qris_bca')
                    ->label('QRIS BCA')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('nmid')
                    ->label('NMID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('list_qris_bank_lain')
                    ->label('List QRIS Bank Lain')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tes_transaksi')
                    ->label('Berhasil Tes Transaksi')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('catatan_kunjungan_program')
                    ->label('Catatan Kunjungan - Program bank lain')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kendala')
                    ->label('Kendala')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request')
                    ->label('Request')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_struk')
                    ->label('Jumlah Struk Diberikan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_lapor_halo')
                    ->label('IDLaporHalo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pengajuan_merchant')
                    ->label('Pengajuan Merchant BCA')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aplikasi_pendaftaran')
                    ->label('Aplikasi Pendaftaran')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fdm_id')
                    ->label('FDM ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alasan_tidak_bersedia')
                    ->label('Alasan Tidak Bersedia')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mempunyai_edc')
                    ->label('Mempunyai EDC BCA Sebelumnya?')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Yes' : 'No';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan_lain')
                    ->label('Keterangan Lain')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_referensi')
                    ->label('Nomor Referensi Pengajuan Merchant Baru')
                    ->searchable()
                    ->sortable(),

                // FOTO
                Tables\Columns\ImageColumn::make('foto_struk')
                    ->label('Foto Struk Transaksi'),
                Tables\Columns\ImageColumn::make('foto_tampak_depan')
                    ->label('Foto Tampak Depan (Plang Nama'),
                Tables\Columns\ImageColumn::make('foto_meja_kasir')
                    ->label('Foto Meja Kasir (Terilihat EDC/QRIS'),
                Tables\Columns\ImageColumn::make('foto_qris_statis')
                    ->label('Foto QRIS Statis'),
                Tables\Columns\ImageColumn::make('foto_selfie')
                    ->label('Foto Selfie Dengan Pemilik Usaha/PIC Toko'),
                Tables\Columns\ImageColumn::make('foto_produk')
                    ->label('Foto Produk di Merchant'),
                Tables\Columns\ImageColumn::make('screen_capture')
                    ->label('Screen Capture Laporan ke Halo BCA'),
                Tables\Columns\TextColumn::make('tanggal_submit')
                    ->label('Tanggal Submit')
                    ->formatStateUsing(function($state){
                        return Carbon::parse($state)->setTimezone('Asia/Jakarta')->format('d/m/Y');
                    })
                    ->searchable(isIndividual: true, query: function($query, $search) {
                        $query->whereRaw("DATE_FORMAT(CONVERT_TZ(tanggal_submit, '+00:00', '+07:00'), '%d/%m/%Y') LIKE ?", ["%{$search}%"]);
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_submit')
                    ->label('Waktu Submit')
                    ->formatStateUsing(function($state){
                        return Carbon::parse($state)->setTimezone('Asia/Jakarta')->format('H:i:s');
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_surveyor')
                    ->label('Nama Surveyor')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('upline1')
                    ->label('Upline 1')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sales_code')
                    ->label('Sales Code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lat')
                    ->label('Latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('long')
                    ->label('Longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updatedBy.name')
                    ->label('Updated By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->formatStateUsing(function($state){
                        return Carbon::parse($state)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->formatStateUsing(function($state){
                        return Carbon::parse($state)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()->hasRole('SUPERADMIN')),
            ])
            ->paginated([5, 10, 25, 50, 100])
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
