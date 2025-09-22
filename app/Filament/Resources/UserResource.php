<?php

namespace App\Filament\Resources;

use App\Enums\BloodTypeEnum;
use App\Enums\CivilStatusEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\TypeUserEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Models\IdentificationType;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Models\UbigeoService;
use App\Services\Utils\IdentificationService;
use App\Services\Utils\PasswordGeneratorService;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Tapp\FilamentCountryCodeField\Forms\Components\CountryCodeSelect;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getNavigationGroup(): ?string
    {
        return __('navigation-panel.Administration');
    }

    public static function getNavigationLabel(): string
    {
        return __('users.navegation_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('users.navegation_label');
    }

    public static function getModelLabel(): string
    {
        return __('users.navegation_label_singel');
    }

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('users.User_information'))
                    ->icon('heroicon-m-user')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->translateLabel()
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->translateLabel()
                            ->email()
                            ->required(),
                    ]),

                Section::make(__('users.Security'))
                    ->icon('heroicon-m-adjustments-vertical')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->translateLabel()
                            ->password()
                            ->visibleOn('create')
                            ->revealable()
                            ->required()
                            ->prefixAction(
                                Forms\Components\Actions\Action::make('generate')
                                    ->icon('heroicon-m-key')
                                    ->action(function ($set) {
                                        $set('password', app(PasswordGeneratorService::class)->generate());
                                    })
                            )
                            ->maxLength(255),
                        Forms\Components\Select::make('roles')
                            ->translateLabel()
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('type_user')
                            ->translateLabel()
                            ->options(TypeUserEnum::Options())
                            ->preload()
                            ->required()
                            ->disabled(fn (callable $get) => $get('is_disabled') ?? false)
                            ->afterStateHydrated(function (mixed $component, mixed $state, callable $set, string $context) {
                                if ($context === 'edit') {
                                    $set('is_disabled', true);
                                }
                            })
                            ->prefixAction(
                                Forms\Components\Actions\Action::make('toggleEdit')
                                    ->icon(fn (callable $get) => $get('is_disabled') ? 'heroicon-m-lock-closed' : 'heroicon-m-lock-open')
                                    ->tooltip(fn (callable $get) => $get('is_disabled') ? 'Habilitar edición' : 'Deshabilitar edición')
                                    ->action(function (callable $set, callable $get) {
                                        $set('is_disabled', ! $get('is_disabled'));
                                    })
                                    ->visible(fn (string $context): bool => $context === 'edit')
                            )
                            ->default(TypeUserEnum::SIMPLE->value)
                            ->live()
                            ->searchable(),
                    ]),

                Section::make(__('users.Profile'))
                    ->icon('heroicon-m-adjustments-vertical')
                    ->collapsible()
                    ->live()
                    ->hidden(fn (callable $get): bool => $get('type_user') === TypeUserEnum::SIMPLE->value)
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('profile')
                            ->translateLabel()
                            ->relationship('profile')
                            ->deletable(false)
                            ->schema([
                                Forms\Components\Select::make('identification_type_id')
                                    ->translateLabel()
                                    ->searchable()
                                    ->preload()
                                    ->relationship('identificationType', 'name')
                                    ->default(2)
                                    ->live(),
                                Forms\Components\TextInput::make('document_number')
                                    ->translateLabel()
                                    ->disabled(fn (callable $get) => $get('is_disabled') ?? false)
                                    ->afterStateHydrated(function (mixed $component, mixed $state, callable $set, string $context) {
                                        if ($context === 'edit') {
                                            $set('is_disabled', true);
                                        }
                                    })
                                    ->prefixAction(
                                        Forms\Components\Actions\Action::make('toggleEdit')
                                            ->icon(fn (callable $get) => $get('is_disabled') ? 'heroicon-m-lock-closed' : 'heroicon-m-lock-open')
                                            ->tooltip(fn (callable $get) => $get('is_disabled') ? 'Habilitar edición' : 'Deshabilitar edición')
                                            ->action(function (callable $set, callable $get) {
                                                $set('is_disabled', ! $get('is_disabled'));
                                            })
                                            ->visible(fn (string $context): bool => $context === 'edit')
                                    )
                                    ->live()
                                    ->unique(ignoreRecord: true)
                                    ->suffixAction(
                                        Forms\Components\Actions\Action::make('generate')
                                            ->icon('heroicon-m-magnifying-glass')
                                            ->action(function (?string $state, callable $set, callable $get) {
                                                app(IdentificationService::class)->setFullName($state, $set);
                                            })
                                            ->visible(
                                                fn (callable $get, string $context): bool => in_array($get('identification_type_id'), IdentificationType::dniRuc()) &&
                                                    $context !== 'view' &&
                                                    ($context !== 'edit' || ! ($get('is_disabled') ?? true))
                                            ),
                                    )->extraAttributes(fn (Forms\Components\TextInput $component) => [
                                        'wire:keydown.enter.prevent' => "mountFormComponentAction('{$component->getStatePath()}', 'generate')",
                                    ])
                                    ->maxLength(11),
                                Forms\Components\TextInput::make('full_name')
                                    ->translateLabel()
                                    ->maxLength(255),
                                Forms\Components\Select::make('gender')
                                    ->translateLabel()
                                    ->options([
                                        'M' => ('Masculino'),
                                        'F' => ('Femenino'),
                                        'O' => ('Otro'),
                                    ])
                                    ->placeholder(__('Select gender'))
                                    ->searchable(),
                                Forms\Components\DatePicker::make('date_of_birth')
                                    ->translateLabel()
                                    ->displayFormat('d F Y')
                                    ->locale('es')
                                    ->native(false),
                                Forms\Components\Select::make('civil_status')
                                    ->translateLabel()
                                    ->options(CivilStatusEnum::options())
                                    ->searchable()
                                    ->placeholder('Estado civil'),
                                Forms\Components\Select::make('education_level')
                                    ->translateLabel()
                                    ->options(EducationLevelEnum::options())
                                    ->searchable(),
                                Forms\Components\Select::make('blood_type')
                                    ->translateLabel()
                                    ->native(false)
                                    ->options(BloodTypeEnum::options()),
                            ])
                            ->columns(3)
                            ->addable()
                            ->maxItems(1),
                        Forms\Components\Repeater::make('mobiles')
                            ->translateLabel()
                            ->relationship('mobiles')
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('mobile_type')
                                    ->translateLabel()
                                    ->maxLength(50)
                                    ->default('Personal')
                                    ->nullable(),
                                CountryCodeSelect::make('country_code')
                                    ->default('+51')
                                    ->translateLabel(),
                                Forms\Components\TextInput::make('mobile_number')
                                    ->translateLabel()
                                    ->tel()
                                    ->maxLength(15),
                            ])
                            ->addable()
                            ->maxItems(2)
                            ->columns(3),
                        Forms\Components\Repeater::make('addresses')
                            ->translateLabel()
                            ->relationship('addresses')
                            ->collapsible()
                            ->maxItems(2)
                            ->schema([
                                Forms\Components\Select::make('ubigeo_cod')
                                    ->translateLabel()
                                    ->default('080101')
                                    ->searchable()
                                    ->placeholder('Buscar por distrito o provincia')
                                    ->getSearchResultsUsing(function (string $search) {
                                        return app(UbigeoService::class)
                                            ->search($search)
                                            ->mapWithKeys(fn ($ubigeo) => [
                                                $ubigeo->cod_ubigeo => "{$ubigeo->district} ({$ubigeo->province}, {$ubigeo->departament})",
                                            ])
                                            ->toArray();
                                    })
                                    ->getOptionLabelUsing(function ($value) {
                                        $ubigeo = app(UbigeoService::class)
                                            ->search($value)
                                            ->first();

                                        return $ubigeo ? "{$ubigeo->district} ({$ubigeo->province}, {$ubigeo->departament})" : '';
                                    }),
                                Forms\Components\TextInput::make('address')
                                    ->translateLabel(),
                                Forms\Components\Textarea::make('reference')
                                    ->translateLabel()
                                    ->autosize()
                                    ->rows(1)
                                    ->maxLength(255),

                            ])->columns(3),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->translateLabel()
                    ->searchable()
                    ->default('Sin Roles')
                    ->badge(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->translateLabel()
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
                Tables\Actions\Action::make('changePassword')
                    ->label('Nueva Clave')
                    ->icon('heroicon-o-lock-closed')
                    ->visible(fn () => app(AuthService::class)->IsSuperUser())
                    ->modalWidth('md')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->translateLabel()
                            ->disabled()
                            ->default(fn (User $record) => $record->name),
                        Forms\Components\TextInput::make('email')
                            ->translateLabel()
                            ->disabled()
                            ->default(fn (User $record) => $record->email),
                        Forms\Components\TextInput::make('password')
                            ->translateLabel()
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->revealable()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('password_confirmation', $state);
                            })
                            ->prefixAction(
                                Forms\Components\Actions\Action::make('generate')
                                    ->icon('heroicon-m-key')
                                    ->action(function ($set) {
                                        $password = app(PasswordGeneratorService::class)->generate();
                                        $set('password', $password);
                                        $set('password_confirmation', $password);
                                    })
                            ),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->translateLabel()
                            ->password()
                            ->required()
                            ->revealable()
                            ->live()
                            ->maxLength(255)
                            ->same('password'),
                    ])
                    ->action(function (User $record, array $data) {
                        $record->update(['password' => \Illuminate\Support\Facades\Hash::make($data['password'])]);
                    }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
