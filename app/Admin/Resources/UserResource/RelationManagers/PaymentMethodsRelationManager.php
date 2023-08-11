<?php

namespace App\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PaymentMethodsRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentMethods';

    protected static ?string $recordTitleAttribute = 'account_number';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('account_type')
                    ->options([
                        'bank' => 'Bank',
                        'mobile_money' => 'Mobile Money',
                        'card' => 'Card',
                    ])
                    ->required()
                    ->default('bank'),
                Forms\Components\TextInput::make('account_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_country')
                    ->maxLength(255),
                Forms\Components\Select::make('momo_provider')
                    ->options([
                        'MTN' => 'MTN',
                        'Vodafone' => 'Vodafone',
                        'AirtelTigo' => 'AirtelTigo',
                    ])
                    ->default('mtn'),
                Forms\Components\TextInput::make('card_number')
                    ->maxLength(255),
                Forms\Components\Select::make('card_type')
                    ->options([
                        'visa' => 'Visa',
                        'mastercard' => 'Mastercard',
                    ])
                    ->default('visa'),
                Forms\Components\TextInput::make('card_expiry')
                    ->minLength(5)
                    ->maxLength(5),
                Forms\Components\TextInput::make('card_cvv')
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TextInput::make('card_holder')
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        '0' => 'Inactive',
                        '1' => 'Active',
                    ])
                    ->required()
                    ->default('1'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account_number')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($record) {
                        return $record->account_number ?? 'Not Provided';
                    }),
                Tables\Columns\TextColumn::make('account_name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($record) {
                        return $record->account_name ?? 'Not Provided';
                    }),
                Tables\Columns\TextColumn::make('account_type')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($record) {
                        return Str::headline($record->account_type);
                    }),
                Tables\Columns\TextColumn::make('bank_name')
                    ->formatStateUsing(function ($record) {
                        return $record->bank_name ?? 'Not Provided';
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('Creation Date'))
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
