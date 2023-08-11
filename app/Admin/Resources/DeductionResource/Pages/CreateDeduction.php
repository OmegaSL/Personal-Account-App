<?php

namespace App\Admin\Resources\DeductionResource\Pages;

use App\Admin\Resources\DeductionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeduction extends CreateRecord
{
    protected static string $resource = DeductionResource::class;
}
