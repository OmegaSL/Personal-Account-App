<?php

namespace App\Admin\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use App\Admin\Resources\UserResource\Pages;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput\Mask;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Admin\Resources\UserResource\RelationManagers;
use App\Admin\Resources\UserResource\RelationManagers\DeductionsRelationManager;
use App\Admin\Resources\UserResource\RelationManagers\PaymentMethodsRelationManager;
use App\Admin\Resources\UserResource\RelationManagers\DeductionHistoriesRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 0;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static function getNavigationLabel(): string
    {
        return trans('Users');
    }

    public static function getPluralLabel(): string
    {
        return trans('Users');
    }

    public static function getLabel(): string
    {
        return trans('User');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('User Management');
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }

    public static function form(Form $form): Form
    {
        if (auth()->user()->hasRole('super_admin')) {
            $roles = fn (string $search) => Role::where('name', 'like', "%{$search}%")
                ->limit(20)
                ->pluck('name', 'id');
        } else {
            $roles = fn (string $search) => Role::where('name', 'like', "%{$search}%")
                ->where('name', '!=', 'super_admin')
                ->limit(20)
                ->pluck('name', 'id');
        }

        // get the country list from the helper and loop through it and get the key and value
        $countries = \App\Helpers\Country::countryList();
        // foreach ($countries as $key => $value) {
        //     $countryList[$key] = $value;
        // }
        // dd($value);

        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('basic_balance')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required(),
                        Forms\Components\TextInput::make('saving_balance')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required(),
                    ])
                    ->columns(2),
                Card::make()
                    ->schema([
                        Forms\Components\FileUpload::make('avatar_url')
                            ->image()
                            ->directory('users')
                            // ->imageCropAspectRatio('16:9')
                            // ->imageResizeTargetWidth('1270')
                            // ->imageResizeTargetHeight('720')
                            ->label('Avatar')
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('name')
                            ->required()->label(trans('Name'))
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('first_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()->required()
                            ->label(trans('Email'))
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')->label(trans('Password'))
                            ->password()
                            ->required(fn ($record) => is_null($record))
                            ->maxLength(255)
                            ->autocomplete('off')
                            ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : ""),
                    ])
                    ->columns(2),
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone')
                            ->numeric()
                            ->mask(fn (Mask $mask) => $mask->pattern('+{233}(00)0000-000')),
                        Forms\Components\TextInput::make('address')->label('Address')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('state')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->maxLength(255),
                        Forms\Components\Select::make('country')
                            ->options([
                                'gh' => 'Ghana',
                                'ng' => 'Nigeria',
                            ]),
                    ])
                    ->columns(2),
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('postal_code')
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Birthday'),
                        Forms\Components\Select::make('roles')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->getSearchResultsUsing($roles)
                            ->getOptionLabelUsing(fn ($value): ?string => Role::find($value)?->name)
                            ->required()
                            ->label(trans('Roles')),
                        Forms\Components\Toggle::make('status')
                            ->label('Status')
                            ->default(true)
                            ->columnSpan('full'),
                    ])
                    ->columns(2),

                // Forms\Components\DateTimePicker::make('email_verified_at')
                //     ->hidden(function ($record) {
                //         if (isset($record) && !$record->hasRole('super_admin')) {
                //             return true;
                //         }
                //     }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('avatar_url')
                        ->label('Avatar')
                        ->circular()
                        ->grow(false),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('full_name')
                            ->sortable()
                            ->searchable()
                            ->weight('medium')
                            ->label(trans('Name')),
                        Tables\Columns\TextColumn::make('email')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->label(trans('Email')),
                    ]),
                    Tables\Columns\IconColumn::make('email_verified_at')
                        ->sortable()
                        ->searchable()
                        ->boolean()
                        ->label(trans('Verified')),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\BadgeColumn::make('roles.name')
                            ->label(__('Roles'))
                            ->formatStateUsing(fn ($state): string => Str::headline($state))
                            ->colors(['primary'])
                            ->searchable(),
                        Tables\Columns\TextColumn::make('created_at')
                            ->label(trans('Creation Date'))
                            ->dateTime('M j, Y')
                            ->sortable(),
                    ])->visibleFrom('sm'),

                ])->from('sm'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('verified')
                    ->label(trans('Email Verified'))
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('unverified')
                    ->label(trans('Email Unverified'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(function ($record) {
                        if ($record->hasRole('super_admin')) {
                            return true;
                        }
                    }),
                Tables\Actions\ForceDeleteAction::make()
                    ->hidden(function ($record) {
                        if ($record->hasRole('super_admin')) {
                            return true;
                        }
                    }),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                // Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PaymentMethodsRelationManager::class,
            DeductionsRelationManager::class,
            DeductionHistoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
