<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitResource\Pages;
use App\Filament\Resources\VisitResource\RelationManagers;
use App\Models\MapingArea;
use App\Models\Visit;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('order_id')
                        ->required()
                        ->maxLength(10),
                    Forms\Components\TextInput::make('nama_usaha')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('key_search')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('alamat_usaha')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('keterangan_lokasi')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nama_lokasi')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('alamat_edc_sesuai')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('mall')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('apakah_ada_edc')
                        ->required()
                        ->maxLength(10),
                    Forms\Components\TextInput::make('jumlah_edc')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('mid')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('tid')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('nama_pemilik')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('nomor_kontak_pemilik')
                        ->required()
                        ->maxLength(20),
                    Forms\Components\TextInput::make('edc_bank_lain')
                        ->required()
                        ->maxLength(10),
                    Forms\Components\TextInput::make('daftar_edc_bank_lain')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('qris')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('qris_bank')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('cat_edukasi_penggunaan_edc')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cat_sosialisasi_aplikasi')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cat_informasi_brand')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cat_tes_transaksi')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ken_jaringan')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ken_baterai')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ken_adaptor')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ken_tombol')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ken_others')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ken_tidak_ada_kendala')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ken_hardware')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ken_komunikasi')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ken_lainnya')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('jumlah_kertas')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('id_lapor_halo')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('request_tambahan_fasilitas')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('request_ganti_ke_apos')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('request_tambah_cabang')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('request_tambah_terminal')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('request_permintaan_struk')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('request_others')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('pengajuan_existing')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('pengajuan_merchant_bca')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('aplikasi_pendaftaran')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fdm_id')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('alasan_tidak_bersedia')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('mempunyai_edc_bca')
                        ->required()
                        ->options([
                            'option1' => 'Punya',
                            'option2' => 'Tidak Punya',
                        ]),
                    Forms\Components\TextInput::make('keterangan_lain')
                        ->required(),
                    Forms\Components\FileUpload::make('foto_struk_transaksi')
                        ->required()
                        ->maxSize(2 * 1024 * 1024) // 2MB
                        ->image()
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            return 'foto_struk_transaksi_' . time() . '.' . $file->getClientOriginalExtension();
                        })
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                        ->hintColor('primary'),
                    Forms\Components\FileUpload::make('foto_tampak_depan')
                        ->required()
                        ->maxSize(2 * 1024 * 1024) // 2MB
                        ->image()
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            return 'foto_tampak_depan_' . time() . '.' . $file->getClientOriginalExtension();
                        })
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                        ->hintColor('primary'),
                    Forms\Components\FileUpload::make('foto_meja_kasir')
                        ->required()
                        ->maxSize(2 * 1024 * 1024) // 2MB
                        ->image()
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            return 'foto_meja_kasir_' . time() . '.' . $file->getClientOriginalExtension();
                        })
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                        ->hintColor('primary'),
                    Forms\Components\FileUpload::make('foto_qris_statis')
                        ->required()
                        ->maxSize(2 * 1024 * 1024) // 2MB
                        ->image()
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            return 'foto_qris_statis_' . time() . '.' . $file->getClientOriginalExtension();
                        })
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                        ->hintColor('primary'),
                    Forms\Components\FileUpload::make('foto_selfie_dengan_pemilik')
                        ->required()
                        ->maxSize(2 * 1024 * 1024) // 2MB
                        ->image()
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            return 'foto_selfie_dengan_pemilik_' . time() . '.' . $file->getClientOriginalExtension();
                        })
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                        ->hintColor('primary'),
                    Forms\Components\FileUpload::make('foto_produk')
                        ->required()
                        ->maxSize(2 * 1024 * 1024) // 2MB
                        ->image()
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            return 'foto_produk_' . time() . '.' . $file->getClientOriginalExtension();
                        })
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                        ->hintColor('primary'),
                    Forms\Components\FileUpload::make('screen_capture')
                        ->required()
                        ->maxSize(2 * 1024 * 1024) // 2MB
                        ->image()
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            return 'screen_capture_' . time() . '.' . $file->getClientOriginalExtension();
                        })
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Max 2MB')
                        ->hintColor('primary'),
                    Forms\Components\DatePicker::make('tanggal_submit')
                        ->required(),
                    Forms\Components\TimePicker::make('time_submit')
                        ->required(),
                    Forms\Components\TextInput::make('nama_surveyor')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('username')
                        ->required()
                        ->default(auth()->user()->name)
                        ->readOnly(),
                    Forms\Components\TextInput::make('upline1')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('upline2')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('upline3')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('kota')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('nip')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('sales_code')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('verifikasi_mid')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('nomor_referensi')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\Toggle::make('status')
                        ->default(true)
                        ->onColor('success')
                        ->offColor('danger')
                        ->required(),
                    Forms\Components\Select::make('area_id')
                        ->relationship('area', 'area_name', fn(Builder $query) => $query->orderBy('area_name'))
                        ->required()
                        ->preload(),
                    Forms\Components\Select::make('maping_area_id')
                        ->relationship('mapingArea', 'maping_area.id', function (Builder $query, $get) {
                            $query->select('maping_area.id', 'area_id', 'sub_area')
                                  ->leftJoin('area', 'maping_area.area_id', '=', 'area.id')
                                  ->addSelect('area.area_name', 'sub_area')
                                  ->orderBy('sub_area');
                        })
                        ->required()
                        ->preload(),
                    Forms\Components\Select::make('province_id')
                        ->relationship('province', 'province_name', fn(Builder $query) => $query->orderBy('province_name'))
                        ->preload()
                        ->required()
                        ->reactive() // Menambahkan reactive
                        ->afterStateUpdated(function (callable $set, $state) {
                            $set('city_id', null); // Reset city_id
                            $set('district_id', null); // Reset district_id
                            $set('subdistrict_id', null); // Reset subdistrict_id
                            $set('poscode_id', null); // Reset poscode_id
                        }),
                    Forms\Components\Select::make('city_id')
                        ->relationship('city', 'city_name', function (Builder $query, $get) {
                            $id = $get('province_id');
                            $query->where('province_id', $id);
                            $query->orderBy('city_name');
                        })
                        ->preload()
                        ->required()
                        ->reactive() // Menambahkan reactive
                        ->afterStateUpdated(function (callable $set, $state) {
                            $set('district_id', null); // Reset district_id
                            $set('subdistrict_id', null); // Reset subdistrict_id
                            $set('poscode_id', null); // Reset poscode_id
                        }),
                    Forms\Components\Select::make('district_id')
                        ->relationship('district', 'district_name', function (Builder $query, $get) {
                            $id = $get('city_id');
                            $query->where('city_id', $id);
                            $query->orderBy('district_name');
                        })
                        ->preload()
                        ->required()
                        ->reactive() // Menambahkan reactive
                        ->afterStateUpdated(function (callable $set, $state) {
                            $set('subdistrict_id', null); // Reset subdistrict_id
                            $set('poscode_id', null); // Reset poscode_id
                        }),
                    Forms\Components\Select::make('subdistrict_id')
                        ->relationship('subdistrict', 'subdistrict_name', function(Builder $query, $get) {
                            $id = $get('district_id');
                            $query->where('district_id', $id);
                            $query->orderBy('subdistrict_name');
                        })
                        ->preload()
                        ->required()
                        ->reactive() // Menambahkan reactive
                        ->afterStateUpdated(function (callable $set, $state) {
                            $set('poscode_id', null); // Reset poscode_id
                        }),
                    Forms\Components\Select::make('poscode_id')
                        ->relationship('poscode', 'poscode', function(Builder $query, $get) {
                            $id = $get('subdistrict_id');
                            $query->where('subdistrict_id', $id);
                            $query->orderBy('poscode');
                        })
                        ->preload()
                        ->required()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->getStateUsing(fn ($rowLoop, $record) => $rowLoop->iteration),
                Tables\Columns\TextColumn::make('order_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_usaha')
                    ->searchable(),
                Tables\Columns\TextColumn::make('key_search')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_usaha')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan_lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_edc_sesuai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mall')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apakah_ada_edc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_edc')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pemilik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_kontak_pemilik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('edc_bank_lain')
                    ->searchable(),
                Tables\Columns\TextColumn::make('daftar_edc_bank_lain')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qris')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qris_bank')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cat_edukasi_penggunaan_edc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cat_sosialisasi_aplikasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cat_informasi_brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cat_tes_transaksi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ken_jaringan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ken_baterai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ken_adaptor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ken_tombol')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ken_others')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ken_tidak_ada_kendala')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ken_hardware')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ken_komunikasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ken_lainnya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_kertas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_lapor_halo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_tambahan_fasilitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_ganti_ke_apos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_tambah_cabang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_tambah_terminal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_permintaan_struk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_others')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pengajuan_existing')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pengajuan_merchant_bca')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aplikasi_pendaftaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fdm_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alasan_tidak_bersedia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mempunyai_edc_bca')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan_lain')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto_struk_transaksi')
                    ->square(),
                Tables\Columns\ImageColumn::make('foto_tampak_depan')
                    ->square(),
                Tables\Columns\ImageColumn::make('foto_meja_kasir')
                    ->square(),
                Tables\Columns\ImageColumn::make('foto_qris_statis')
                    ->square(),
                Tables\Columns\ImageColumn::make('foto_selfie_dengan_pemilik')
                    ->square(),
                Tables\Columns\ImageColumn::make('foto_produk')
                    ->square(),
                Tables\Columns\ImageColumn::make('screen_capture')
                    ->square(),
                Tables\Columns\TextColumn::make('tanggal_submit')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_submit'),
                Tables\Columns\TextColumn::make('nama_surveyor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('upline1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('upline2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('upline3')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('verifikasi_mid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_referensi')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('area.area_name')
                    ->label('Area')
                    ->searchable(),
                Tables\Columns\TextColumn::make('maping_area_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('province.province_name')
                    ->label('Province')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city.city_name')
                    ->label('City')
                    ->searchable(),
                Tables\Columns\TextColumn::make('district.district_name')
                    ->label('District')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subdistrict.subdistrict_name')
                    ->label('Subdistrict')
                    ->searchable(),
                Tables\Columns\TextColumn::make('poscode.poscode')
                    ->label('Poscode')
                    ->searchable(),
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
