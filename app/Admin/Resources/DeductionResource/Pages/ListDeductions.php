<?php

namespace App\Admin\Resources\DeductionResource\Pages;

use App\Admin\Resources\DeductionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeductions extends ListRecords
{
    protected static string $resource = DeductionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
