<?php

namespace App\Admin\Resources\TransactionResource\Pages;

use App\Admin\Resources\TransactionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
