<?php

namespace App\Filament\Resources\PengajuanpembayaranResource\Pages;

use App\Filament\Resources\PengajuanpembayaranResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanpembayaran extends EditRecord
{
    protected static string $resource = PengajuanpembayaranResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
