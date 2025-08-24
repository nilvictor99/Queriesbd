<?php

namespace App\Filament\Resources\ReniecDataResource\Pages;

use App\Filament\Resources\ReniecDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReniecData extends EditRecord
{
    protected static string $resource = ReniecDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
