<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rule;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Administrator Only';

    public static function shouldRegisterNavigation(): bool
    {
    	return Filament::auth()->user()->can('User View');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make() ->schema([
                    TextInput::make('nip')
                        ->label('NIP')
                        ->required()
                        ->placeholder('Nomor Induk Pegawai')
                        ->rules(function(callable $get, $livewire){
                            $recordId = $livewire->getRecord()?->id;
                            return [
                                Rule::unique('users', 'nip')->ignore($recordId)
                            ];
                        })
                        ->maxLength(10),
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Email')
                        ->placeholder('ex@mail.com')
                        ->email()
                        ->required()
                        ->rules(function(callable $get, $livewire){
                            $recordId = $livewire->getRecord()?->id;
                            return [
                                'email',
                                Rule::unique('users', 'email')->ignore($recordId)
                            ];
                        })
                        ->maxLength(255),
                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->revealable()
                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->required()
                        ->maxLength(20)
                        ->label('Nomor HP'),
                    CheckboxList::make('roles')
                        ->label('Roles')
                        ->relationship('roles', 'name')
                        ->columns(2)
                        ->options(function () {
                            if (auth()->user()->hasRole('ADMATS')) {
                                return \App\Models\Role::where('name', 'TEKNISI')->pluck('name', 'id');
                            }
                            return \App\Models\Role::pluck('name', 'id');
                        })
                        ->default(function () {
                            if (auth()->user()->hasRole('ADMATS')) {
                                return \App\Models\Role::where('name', 'TEKNISI')->pluck('id')->toArray();
                            }
                            return [];
                        })
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
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Nomor HP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->sortable(),
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

    // SPATIE PERMISSIONS FUNCTIONS
    public static function canCreate(): bool
    {
        return Auth::user()->can('User Create');
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->can('User View');
    }

    public static function canEdit($record): bool
    {
        $userRoles = Auth::user()->roles->pluck('name')->toArray();
        if (in_array('ADMATS', $userRoles) &&
            (in_array('SUPERADMIN', $record->roles->pluck('name')->toArray()) ||
            in_array('ADMATS', $record->roles->pluck('name')->toArray()) ||
            in_array('ADMBANK', $record->roles->pluck('name')->toArray()))) {
            return false;
        }
        return Auth::user()->can('User Edit');
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
