<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficeResource\Pages;
use App\Models\City;
use App\Models\District;
use App\Models\Office;
use App\Models\Poscode;
use App\Models\Subdistrict;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Pages\Actions\CreateAction;
use Filament\Pages\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;

class OfficeResource extends Resource
{
    protected static ?string $model = Office::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    public static function shouldRegisterNavigation(): bool
    {
    	return Filament::auth()->user()->can('Office View');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make() ->schema([

                    Forms\Components\TextInput::make('code_office')
                        ->required()
                        ->maxLength(10),
                    Forms\Components\TextInput::make('office_name')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('address')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('pic_name')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->required()
                        ->maxLength(20),
                    Forms\Components\Toggle::make('status')
                        ->default(true)
                        ->onColor('success')
                        ->offColor('danger'),
                    Forms\Components\Select::make('vendor_id')
                        ->relationship('vendor', 'vendor_name') // Pastikan 'vendor' adalah nama metode relasi
                        ->preload()
                        ->required(),
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
                Tables\Columns\TextColumn::make('code_office')
                    ->searchable(),
                Tables\Columns\TextColumn::make('office_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pic_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('vendor.vendor_name')
                    ->label('Vendor')
                    ->searchable(),
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
            'index' => Pages\ListOffices::route('/'),
            'create' => Pages\CreateOffice::route('/create'),
            'edit' => Pages\EditOffice::route('/{record}/edit'),
        ];
    }
}
