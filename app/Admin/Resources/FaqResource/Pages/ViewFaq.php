<?php

namespace App\Admin\Resources\FaqResource\Pages;

use App\Admin\Resources\FaqResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFaq extends ViewRecord
{
    protected static string $resource = FaqResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
