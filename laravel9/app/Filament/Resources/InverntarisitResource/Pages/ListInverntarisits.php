<?php

namespace App\Filament\Resources\InverntarisitResource\Pages;

use App\Filament\Resources\InverntarisitResource;
use App\Imports\InventarisitImport;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListInverntarisits extends ListRecords
{
    protected static string $resource = InverntarisitResource::class;

    protected function getActions(): array
    {
        return [
            ButtonAction::make('importExcel')
            ->label('Import Excel')
            ->form([
                FileUpload::make('file')
                    ->label('Upload File Excel')
                    ->directory('excel-imports')
                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'])
                    ->required()
                    ->visibility('public')
            ])
            ->action(function (array $data, $livewire) {
                try {
                    $filePath = storage_path('app/public/' . $data['file']);
                    \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\InventarisitImport, $filePath);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    \Filament\Notifications\Notification::make()
                        ->title('Import Berhasil')
                        ->success()
                        ->send();
                    return ['file' => null]; // reset input
                } catch (\Exception $e) {
                    \Filament\Notifications\Notification::make()
                        ->title('Import Gagal')
                        ->body('Error: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->after(function ($livewire) {
                $livewire->reset(['data.file']);
            }),
            
            Actions\CreateAction::make(),
        ];
    }
}
