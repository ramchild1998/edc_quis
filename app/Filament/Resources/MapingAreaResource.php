<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MapingAreaResource\Pages;
use App\Models\MapingArea;
use App\Models\Subdistrict;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MapingAreaResource extends Resource
{
    protected static ?string $model = MapingArea::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\Select::make('area_id')
                        ->relationship('area', 'area_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    // Select for subdistrict with postal code included
                    Select::make('subdistrict_id')
                        ->label('Subdistrict')
                        ->searchable()
                        ->getSearchResultsUsing(function (string $search) {
                            // Search for subdistricts with matching name and include postal code in the result
                            return Subdistrict::where('subdistrict_name', 'like', "%{$search}%")
                                ->limit(50)
                                ->get()
                                ->mapWithKeys(function ($subdistrict) {
                                    // Display subdistrict name and postal code
                                    return [
                                        $subdistrict->id => $subdistrict->subdistrict_name . ' -> ' . $subdistrict->district->district_name
                                    ];
                                });
                        })
                        ->getOptionLabelUsing(function ($value) {
                            // Display the selected subdistrict with postal code in the form
                            $subdistrict = Subdistrict::find($value);
                            return $subdistrict ? $subdistrict->subdistrict_name . ' -> ' . $subdistrict->district->district_name : null;
                        })
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            // Fetch the selected subdistrict and related province, city, district, and poscode
                            $subdistrict = Subdistrict::find($state);
                            if ($subdistrict) {
                                $set('province_name', $subdistrict->district->city->province->province_name);
                                $set('city_name', $subdistrict->district->city->city_name);
                                $set('district_name', $subdistrict->district->district_name);
                                $set('poscode', $subdistrict->poscodes()->pluck('poscode')->first());
                            } else {
                                $set('province_name', null);
                                $set('city_name', null);
                                $set('district_name', null);
                                $set('poscode', null);
                            }
                        }),

                    // Group display for Province, City, and District
                    Forms\Components\Fieldset::make('Location Details')
                        ->label('Location Information (Display Only)')
                        ->schema([
                            Forms\Components\TextInput::make('province_name')
                                ->label('Province')
                                ->disabled()
                                ->dehydrated(false)
                                ->hint('This field will not be sent to the backend'),

                            Forms\Components\TextInput::make('city_name')
                                ->label('City')
                                ->disabled()
                                ->dehydrated(false)
                                ->hint('This field will not be sent to the backend'),

                            Forms\Components\TextInput::make('district_name')
                                ->label('District')
                                ->disabled()
                                ->dehydrated(false)
                                ->hint('This field will not be sent to the backend'),

                            Forms\Components\TextInput::make('poscode')
                                ->label('Postal Code')
                                ->disabled()
                                ->dehydrated(false)
                                ->hint('This field will not be sent to the backend'),
                        ]),

                        Forms\Components\Toggle::make('status')
                        ->default(true)
                        ->onColor('success')
                        ->offColor('danger')
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('area.area_name')
                    ->label('Area')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subdistrict.subdistrict_name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMapingAreas::route('/'),
            'create' => Pages\CreateMapingArea::route('/create'),
            'edit' => Pages\EditMapingArea::route('/{record}/edit'),
        ];
    }
}
