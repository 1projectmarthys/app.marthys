<?php

namespace App\Filament\Resources\MasterpenagihanResource\Pages;

use App\Filament\Resources\MasterpenagihanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterpenagihans extends ListRecords
{
    protected static string $resource = MasterpenagihanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
