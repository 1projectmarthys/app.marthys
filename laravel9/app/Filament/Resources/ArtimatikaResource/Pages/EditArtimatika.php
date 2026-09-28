<?php

namespace App\Filament\Resources\ArtimatikaResource\Pages;

use App\Filament\Resources\ArtimatikaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtimatika extends EditRecord
{
    protected static string $resource = ArtimatikaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
