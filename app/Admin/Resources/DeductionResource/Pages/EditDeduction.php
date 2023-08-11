<?php

namespace App\Admin\Resources\DeductionResource\Pages;

use App\Admin\Resources\DeductionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeduction extends EditRecord
{
    protected static string $resource = DeductionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
