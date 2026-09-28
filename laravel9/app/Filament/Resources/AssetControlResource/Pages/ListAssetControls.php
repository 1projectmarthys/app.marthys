<?php

namespace App\Filament\Resources\AssetControlResource\Pages;

use App\Filament\Resources\AssetControlResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssetControls extends ListRecords
{
    protected static string $resource = AssetControlResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
