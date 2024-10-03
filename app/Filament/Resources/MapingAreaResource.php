<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MapingAreaResource\Pages;
use App\Filament\Resources\MapingAreaResource\RelationManagers;
use App\Models\MapingArea;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MapingAreaResource extends Resource
{
    protected static ?string $model = MapingArea::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make() ->schema([

                    Forms\Components\TextInput::make('area_id')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('subdistrict_id')
                        ->required()
                        ->numeric(),
                    Forms\Components\Toggle::make('status')
                        ->default(true)
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('area_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subdistrict_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
