<?php

namespace App\Admin\Resources\FaqCategoryResource\Pages;

use App\Admin\Resources\FaqCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaqCategories extends ListRecords
{
    protected static string $resource = FaqCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
