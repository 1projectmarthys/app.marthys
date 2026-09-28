<?php

namespace App\Filament\Resources\ArtimatikaResource\Pages;

use App\Filament\Resources\ArtimatikaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtimatikas extends ListRecords
{
    protected static string $resource = ArtimatikaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
