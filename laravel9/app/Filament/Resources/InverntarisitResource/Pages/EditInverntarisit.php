<?php

namespace App\Filament\Resources\InverntarisitResource\Pages;

use App\Filament\Resources\InverntarisitResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInverntarisit extends EditRecord
{
    protected static string $resource = InverntarisitResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
