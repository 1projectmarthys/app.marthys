<?php

namespace App\Filament\Resources\AssetControlResource\Pages;

use App\Filament\Resources\AssetControlResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssetControl extends EditRecord
{
    protected static string $resource = AssetControlResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
