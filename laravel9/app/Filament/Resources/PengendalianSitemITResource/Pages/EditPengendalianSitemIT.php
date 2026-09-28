<?php

namespace App\Filament\Resources\PengendalianSitemITResource\Pages;

use App\Filament\Resources\PengendalianSitemITResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengendalianSitemIT extends EditRecord
{
    protected static string $resource = PengendalianSitemITResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
