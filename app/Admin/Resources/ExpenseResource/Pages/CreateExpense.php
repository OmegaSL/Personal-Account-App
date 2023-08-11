<?php

namespace App\Admin\Resources\ExpenseResource\Pages;

use App\Admin\Resources\ExpenseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
