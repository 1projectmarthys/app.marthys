<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InverntarisitResource\Pages;
use App\Filament\Resources\InverntarisitResource\RelationManagers;
use App\Models\Inventarisit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventarisitImport;
use Filament\Forms\Components\Actions\Modal\Actions\Action as ActionsAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\ButtonAction;
use Filament\Tables\Actions\Action;

class InverntarisitResource extends Resource
{
    protected static ?string $model = Inventarisit::class;
    protected static ?string $navigationGroup = 'IT';
    protected static ?string $navigationLabel = 'Inventaris';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
        public static function form(Form $form): Form
    {
        
        return $form
            ->schema([
                //
            
            Forms\Components\TextInput::make('nama_barang')
                ->label('Nama Barang')
                ->required(),
            Forms\Components\Textarea::make('spesifikasi_barang')
                ->label('Spesifikasi Barang')
                ->required(),
            Forms\Components\TextInput::make('tahun')
                ->label('Tahun')
                ->numeric(),
               
            Forms\Components\TextInput::make('jumlah')
                ->label('Jumlah')
                ->numeric()
                ->required(),
            Forms\Components\Select::make('kondisi_barang')
                ->label('Kondisi Barang')
                ->options([
                    'baik' => 'Baik',
                    'rusak' => 'Rusak',
                    'perlu_perbaikan' => 'Perlu Perbaikan',
                ])
                ->required(),
            Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
    Tables\Actions\Action::make('Import Excel')
        ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('Upload File Excel')
                        ->directory('excel-imports')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel'
                        ])
                        ->required()
                        ->visibility('public')
                        ->preserveFilenames()
                ])
                ->action(function (array $data, $livewire) {
                    try {
                        $filePath = storage_path('app/public/' . $data['file']);
                        
                        Excel::import(new InventarisitImport, $filePath);
                        
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }

                        Notification::make()
                            ->title('Import Berhasil')
                            ->success()
                            ->send();

                        $livewire->reset();
                            
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Import Gagal')
                            ->body('Error: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->after(function () {
                    return redirect()->route('filament.resources.inverntarisit.index');
                })
        ])
        
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('No')
                ->sortable(),
            Tables\Columns\TextColumn::make('kode_barang')
                ->label('Kode Barang')
                ->searchable(),
            Tables\Columns\TextColumn::make('nama_barang')
                ->label('Nama Barang')
                ->searchable(),
            Tables\Columns\TextColumn::make('spesifikasi_barang')
                ->label('Spesifikasi Barang')
                ->limit(50), // Batasi panjang teks
            Tables\Columns\TextColumn::make('tahun')
                ->label('Tahun')
                ->sortable(),
            Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah')
                ->sortable(),
            Tables\Columns\TextColumn::make('kondisi_barang')
                ->label('Kondisi Barang'),
            Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan')
                ->limit(50), // Batasi panjang teks
        ])
        ->filters([
            // Tambahkan filter jika diperlukan
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInverntarisits::route('/'),
            'create' => Pages\CreateInverntarisit::route('/create'),
            'edit' => Pages\EditInverntarisit::route('/{record}/edit'),
        ];
    }    

    
}
