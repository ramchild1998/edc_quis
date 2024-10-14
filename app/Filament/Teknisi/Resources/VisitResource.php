<?php

namespace App\Filament\Teknisi\Resources;

use App\Filament\Teknisi\Resources\VisitResource\Pages;
use App\Filament\Teknisi\Resources\VisitResource\RelationManagers;
use App\Models\MapingArea;
use App\Models\Visit;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

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
                                ->placeholder('Pilih opsi'),
                            // Forms\Components\Select::make('area_id')
                            //     ->relationship('area', 'id')
                            //     ->required(),
                            // Forms\Components\Select::make('location_id')
                            //     ->relationship('location', 'id')
                            //     ->required(),
                            Forms\Components\Select::make('area_id')
                                ->relationship('area', 'area_name', fn(Builder $query) => $query->orderBy('area_name'))
                                ->required()
                                ->reactive()  // Tambahkan reactive agar bisa memicu perubahan di Maping Area
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Reset pilihan Maping Area saat Area berubah
                                    $set('maping_area_id', null);
                                })
                                ->label('Area ID')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih opsi')
                                ->hint('Pilih area terlebih dahulu')
                                ->hintColor('danger')
                                ->hintIcon('heroicon-o-information-circle'),

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
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih opsi')
                                ->label('Location ID'),
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
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if ($state !== 'Lainnya') {
                                        $set('keterangan_lokasi_lainnya', null);
                                    }
                                })
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih opsi'),

                            Forms\Components\TextInput::make('keterangan_lokasi_lainnya')
                                ->label('Opsi Keterangan Lokasi Lainnya')
                                ->placeholder('Masukkan opsi lainnya')
                                ->maxLength(22)
                                ->visible(fn ($get) => $get('keterangan_lokasi') === 'Lainnya')
                                ->reactive(),

                            Forms\Components\Select::make('province_id')
                                ->relationship('province', 'province_name', fn(Builder $query) => $query->orderBy('province_name'))
                                ->preload()
                                ->required()
                                ->placeholder('Pilih opsi')
                                ->reactive() // Menambahkan reactive
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('city_id', null); // Reset city_id
                                    $set('district_id', null); // Reset district_id
                                    $set('subdistrict_id', null); // Reset subdistrict_id
                                    $set('poscode_id', null); // Reset poscode_id
                                })
                                ->searchable()
                                ->label('Provinsi')
                                ->hint('Pilih provinsi terlebih dahulu')
                                ->hintColor('danger')
                                ->hintIcon('heroicon-o-information-circle'),
                            Forms\Components\Select::make('city_id')
                                ->relationship('city', 'city_name', function (Builder $query, $get) {
                                    $id = $get('province_id');
                                    $query->where('province_id', $id);
                                    $query->orderBy('city_name');
                                })
                                ->preload()
                                ->required()
                                ->placeholder('Pilih opsi')
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
                                ->placeholder('Pilih opsi')
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
                                ->placeholder('Pilih opsi')
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
                                ->placeholder('Pilih opsi')
                                ->searchable()
                                ->label('Kode Pos'),
                        ])
                        ->columns(2),

                    Forms\Components\Section::make('Informasi Merchant')
                    ->schema([

                        Forms\Components\TextInput::make('mid')
                        ->maxLength(9)
                        ->label('MID')
                        ->hint('9 Digit')
                        ->suffixAction(
                            Forms\Components\Actions\Action::make('check')
                                ->label('Check')
                                ->icon('heroicon-m-magnifying-glass')
                                ->action(function ($state, $livewire) {
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
                        ->label('TID')
                        ->separator(',')
                        ->splitKeys(['Tab', 'Enter', ','])
                        ->placeholder('Masukkan TID dan tekan Enter atau Tab')
                        ->columnSpanFull()
                        ->helperText('Masukkan beberapa TID dipisahkan dengan koma. Setiap TID maksimal 8 digit. Contoh: C0141271, C0141272, C0141273')
                        ->formatStateUsing(function ($state) {
                            if (is_string($state)) {
                                return explode(', ', $state);
                            }
                            return $state;
                        })
                        ->formatStateUsing(function ($state) {
                            if (is_array($state)) {
                                return implode(', ', $state);
                            }
                            return $state;
                        })
                        ->rules([
                            function () {
                                return function (string $attribute, $value, Closure $fail) {
                                    $tids = explode(',', $value);
                                    foreach ($tids as $tid) {
                                        $tid = trim($tid);
                                        if (strlen($tid) > 8) {
                                            $fail("Setiap TID harus maksimal 8 digit. '$tid' melebihi batas.");
                                        }
                                    }
                                };
                            },
                        ]),


                        Forms\Components\TextInput::make('nomor_sn')
                            ->label('Nomor SN')
                            ->maxLength(24),
                        Forms\Components\TextInput::make('nama_pemilik')
                            ->label('Nama Pemilik Usaha/Rekening')
                            ->maxLength(45),
                        Forms\Components\TextInput::make('no_kontak')
                            ->label('No. Kontak Pemilik Usaha/PIC Toko')
                            ->maxLength(20),
                        Forms\Components\Select::make('alamat_edc_sesuai')
                            ->label('Alamat Edc Sesuai ?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),
                        Forms\Components\Select::make('ada_edc_bca')
                            ->label('Ada EDC BCA ?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),
                        Forms\Components\TextInput::make('jumlah_edc')
                            ->label('Jumlah EDC')
                            ->numeric(),
                        Forms\Components\Select::make('edc_bank_lain')
                            ->label('EDC Bank Lain ?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),
                        Forms\Components\Textarea::make('list_edc_bank_lain')
                            ->label('List EDC Bank Lain')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('catatan_kunjungan_edc')
                            ->label('Catatan Kunjungan - EDC utama yang digunakan')
                            ->maxLength(22),
                        Forms\Components\Select::make('qris_bca')
                            ->label('Qris BCA ?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),
                        Forms\Components\TextInput::make('nmid')
                            ->label('NMID')
                            ->maxLength(15),
                        Forms\Components\Textarea::make('list_qris_bank_lain')
                            ->label('List Qris Bank Lain')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('tes_transaksi')
                            ->label('Berhasil Tes Transaksi ?')
                            ->placeholder('Pilih opsi')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),
                        Forms\Components\TextInput::make('catatan_kunjungan_program')
                            ->label('Catatan Kunjungan - Program bank lain')
                            ->maxLength(50),
                        Forms\Components\Textarea::make('kendala')
                            ->label('Kendala')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('request')
                            ->label('Request')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('jumlah_struk')
                            ->label('Jumlah Struk Diberikan')
                            ->numeric(),
                        Forms\Components\TextInput::make('id_lapor_halo')
                            ->label('ID Lapor Halo')
                            ->maxLength(8),
                    ])->columns(2),

                    Forms\Components\Section::make('Informasi Merchant Potensial')
                    ->schema([
                        Forms\Components\TextInput::make('pengajuan_merchant')
                            ->maxLength(15),
                        Forms\Components\TextInput::make('aplikasi_pendaftaran')
                            ->maxLength(25),
                        Forms\Components\TextInput::make('fdm_id')
                            ->maxLength(7),
                        Forms\Components\TextInput::make('alasan_tidak_bersedia')
                            ->maxLength(50),
                        Forms\Components\Toggle::make('mempunyai_edc'),
                        Forms\Components\TextInput::make('keterangan_lain')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('nomor_referensi')
                            ->maxLength(255),
                    ])->columns(2),

                    Forms\Components\Section::make('Bukti Kunjungan')
                    ->schema([

                    Forms\Components\FileUpload::make('foto_struk')
                        ->required()
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
                        ->label('Struk Transaksi'),

                    Forms\Components\FileUpload::make('foto_tampak_depan')
                        ->required()
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
                        ->label('Tampak Depan'),

                    Forms\Components\FileUpload::make('foto_meja_kasir')
                        ->required()
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
                        ->label('Meja Kasir'),

                    Forms\Components\FileUpload::make('foto_qris_statis')
                        ->required()
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
                        ->required()
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
                        ->label('Foto Selfie Dengan Pemilik'),

                    Forms\Components\FileUpload::make('foto_produk')
                        ->required()
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
                        ->label('Foto Produk'),

                    Forms\Components\FileUpload::make('screen_capture')
                        ->required()
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
                        ->label('Screen Capture'),
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
                Tables\Columns\TextColumn::make('maping_area.maping_area_name')
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
                Tables\Columns\TextColumn::make('province_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('district_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subdistrict_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('poscode_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_sn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pemilik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_kontak')
                    ->searchable(),
                Tables\Columns\IconColumn::make('alamat_edc_sesuai')
                    ->boolean(),
                Tables\Columns\IconColumn::make('ada_edc_bca')
                    ->boolean(),
                Tables\Columns\TextColumn::make('jumlah_edc')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('edc_bank_lain')
                    ->boolean(),
                Tables\Columns\TextColumn::make('catatan_kunjungan_edc')
                    ->searchable(),
                Tables\Columns\IconColumn::make('qris_bca')
                    ->boolean(),
                Tables\Columns\TextColumn::make('nmid')
                    ->searchable(),
                Tables\Columns\IconColumn::make('tes_transaksi')
                    ->boolean(),
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
                Tables\Columns\IconColumn::make('mempunyai_edc')
                    ->boolean(),
                Tables\Columns\TextColumn::make('keterangan_lain')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_referensi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto_struk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto_tampak_depan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto_meja_kasir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto_qris_statis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto_selfie')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto_produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('screen_capture')
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
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
