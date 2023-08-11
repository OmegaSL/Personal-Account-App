<?php

namespace App\Admin\Resources\TransactionResource\Pages;

use App\Admin\Resources\TransactionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
