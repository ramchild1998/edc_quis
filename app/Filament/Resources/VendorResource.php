<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorResource\Pages;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Models\Vendor;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-office-2';

    public static function shouldRegisterNavigation(): bool
    {
    	return Filament::auth()->user()->can('Office View');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([

                    Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->getStateUsing(fn ($rowLoop, $record) => $rowLoop->iteration),
                    Forms\Components\TextInput::make('vendor_name')
                        ->label('Vendor')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('pic_name')
                        ->label('PIC')
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('email')
                        ->label('Email PIC')
                        ->email()
                        ->required()
                        ->maxLength(45),
                    Forms\Components\TextInput::make('phone')
                        ->label('Phone PIC')
                        ->tel()
                        ->required()
                        ->maxLength(20),
                    Forms\Components\Toggle::make('status')
                        ->label('Status')
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
                Tables\Columns\TextColumn::make('index')
                ->label('#')
                ->getStateUsing(fn ($rowLoop, $record) => $rowLoop->iteration),
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->hidden(),
                Tables\Columns\TextColumn::make('vendor_name')
                    ->label('Vendor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pic_name')
                    ->label('PIC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email PIC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone PIC')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
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
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
