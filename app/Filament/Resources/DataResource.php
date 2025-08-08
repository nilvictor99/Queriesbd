<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataResource\Pages;
use App\Models\Data;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DataResource extends Resource
{
    protected static ?string $model = Data::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('document_number')
                    ->required()
                    ->maxLength(8),
                Forms\Components\TextInput::make('cod_verificacion')
                    ->maxLength(255),
                Forms\Components\TextInput::make('paternal_last_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('maternal_last_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gender')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_of_birth'),
                Forms\Components\DatePicker::make('date_of_death'),
                Forms\Components\TextInput::make('department')
                    ->maxLength(255),
                Forms\Components\TextInput::make('province')
                    ->maxLength(255),
                Forms\Components\TextInput::make('district')
                    ->maxLength(255),
                Forms\Components\TextInput::make('marital_status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('education_level')
                    ->maxLength(255),
                Forms\Components\TextInput::make('height')
                    ->numeric(),
                Forms\Components\DatePicker::make('registration_date'),
                Forms\Components\DatePicker::make('issue_date'),
                Forms\Components\DatePicker::make('expiration_date'),
                Forms\Components\TextInput::make('father')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mother')
                    ->maxLength(255),
                Forms\Components\Textarea::make('restrictions')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ubigeo_reniec')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ubigeo_inei')
                    ->maxLength(6),
                Forms\Components\TextInput::make('ubigeo_sunat')
                    ->maxLength(6),
                Forms\Components\TextInput::make('postal_code')
                    ->maxLength(5),
                Forms\Components\Textarea::make('photo')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('document_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cod_verificacion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paternal_last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('maternal_last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_death')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('province')
                    ->searchable(),
                Tables\Columns\TextColumn::make('district')
                    ->searchable(),
                Tables\Columns\TextColumn::make('marital_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('education_level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('height')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('registration_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiration_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('father')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mother')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ubigeo_reniec')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ubigeo_inei')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ubigeo_sunat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
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
            'index' => Pages\ListData::route('/'),
            'create' => Pages\CreateData::route('/create'),
            'edit' => Pages\EditData::route('/{record}/edit'),
        ];
    }
}
