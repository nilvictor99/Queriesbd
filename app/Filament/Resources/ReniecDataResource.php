<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReniecDataResource\Pages;
use App\Models\ReniecData;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReniecDataResource extends Resource
{
    protected static ?string $model = ReniecData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Información personal')
                    ->icon('heroicon-m-identification')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('document_number')
                            ->translateLabel()
                            ->required(),

                        \Filament\Forms\Components\TextInput::make('name')
                            ->translateLabel()
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('paternal_last_name')
                            ->translateLabel()
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('maternal_last_name')
                            ->translateLabel()
                            ->required(),

                        \Filament\Forms\Components\Select::make('gender')
                            ->translateLabel()
                            ->options([
                                'M' => 'Masculino',
                                'F' => 'Femenino',
                            ])
                            ->native(false),
                        \Filament\Forms\Components\DatePicker::make('date_of_birth')
                            ->translateLabel()
                            ->native(false),
                        \Filament\Forms\Components\DatePicker::make('date_of_death')
                            ->translateLabel()
                            ->native(false),
                        \Filament\Forms\Components\TextInput::make('cod_verificacion')
                            ->translateLabel(),
                    ])->columns(4),

                \Filament\Forms\Components\Section::make('Ubicación')
                    ->icon('heroicon-m-map-pin')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('department')
                            ->translateLabel(),
                        \Filament\Forms\Components\TextInput::make('province')
                            ->translateLabel(),
                        \Filament\Forms\Components\TextInput::make('district')
                            ->translateLabel(),
                        \Filament\Forms\Components\TextInput::make('address')
                            ->translateLabel(),
                        \Filament\Forms\Components\TextInput::make('ubigeo_reniec')
                            ->translateLabel(),
                        \Filament\Forms\Components\TextInput::make('ubigeo_inei')
                            ->translateLabel(),
                        \Filament\Forms\Components\TextInput::make('ubigeo_sunat')
                            ->translateLabel(),
                        \Filament\Forms\Components\TextInput::make('postal_code')
                            ->translateLabel(),
                    ])->columns(4),

                \Filament\Forms\Components\Section::make('Datos complementarios')
                    ->icon('heroicon-m-information-circle')
                    ->schema([
                        \Filament\Forms\Components\Select::make('marital_status')
                            ->translateLabel()
                            ->options([
                                'S' => 'Soltero/a',
                                'C' => 'Casado/a',
                                'V' => 'Viudo/a',
                                'D' => 'Divorciado/a',
                            ])->native(false),
                        \Filament\Forms\Components\TextInput::make('education_level')
                            ->translateLabel(),
                        \Filament\Forms\Components\TextInput::make('height')
                            ->translateLabel(),
                        \Filament\Forms\Components\DatePicker::make('registration_date')
                            ->translateLabel()
                            ->native(false),
                        \Filament\Forms\Components\DatePicker::make('issue_date')
                            ->translateLabel()
                            ->native(false),
                        \Filament\Forms\Components\DatePicker::make('expiration_date')
                            ->translateLabel()
                            ->native(false),
                    ])->columns(3),

                \Filament\Forms\Components\Section::make('Filiación')
                    ->icon('heroicon-m-users')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('father')
                            ->translateLabel(),
                        \Filament\Forms\Components\TextInput::make('mother')
                            ->translateLabel(),
                        \Filament\Forms\Components\Textarea::make('restrictions')
                            ->translateLabel()
                            ->rows(1),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->translateLabel(),
                Tables\Columns\TextColumn::make('paternal_last_name')->translateLabel(),
                Tables\Columns\TextColumn::make('maternal_last_name')->translateLabel(),
                Tables\Columns\TextColumn::make('document_number')
                    ->translateLabel()
                    ->formatStateUsing(function ($state, $record) {
                        return $state.($record->cod_verificacion ? '-'.$record->cod_verificacion : '');
                    })
                    ->badge()
                    ->color('info')
                    ->copyable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
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
            'index' => Pages\ListReniecData::route('/'),
            'create' => Pages\CreateReniecData::route('/create'),
            'edit' => Pages\EditReniecData::route('/{record}/edit'),
        ];
    }
}
