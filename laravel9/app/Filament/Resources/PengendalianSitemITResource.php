<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengendalianSitemITResource\Pages;
use App\Filament\Resources\PengendalianSitemITResource\RelationManagers;
use App\Models\Pengendaliansistemit;
use App\Models\PengendalianSitemIT;
use Filament\Forms;
use Filament\Forms\Components\Actions\Modal\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class PengendalianSitemITResource extends Resource
{
    protected static ?string $model = Pengendaliansistemit::class;
    protected static ?string $navigationGroup = 'IT';
    protected static ?string $navigationLabel = 'Pengendalian Sistem IT';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                 // Bagian Bulan
                Select::make('bulan')
                    ->label('Bulan')
                    ->options(collect(range(1, 12))->mapWithKeys(fn ($month) => [
                        $month => Carbon::create()->month($month)->format('F')
                    ]))
                    ->required()
                    ->searchable(),
                Hidden::make('tahun')
                    ->default(now()->year)
                    ->required(),
               
                Select::make('pengontrol')
                    ->label('Nama Pengontrol')
                    ->options([
                        'rochim.png' => 'RCHM',
                        'adit.png' => 'ADYP',
                       
                        // Tambahkan opsi lainnya sesuai kebutuhan
                    ])
                    ->required()
                    ->searchable(), 
                Select::make('nama')
                    ->label('Nama')
                    ->options([
                        'PC HRD' => 'PC HRD',
                        'PC IT' => 'PC IT',
                        'PC PENJUALAN' => 'PC PENJUALAN',
                        'PC PENJUALAN 2' => 'PC PENJUALAN 2',
                        'PC ADMIN PENJUALAN' => 'PC ADMIN PENJUALAN',
                        'PC PURCHASING' => 'PC PURCHASING',
                        'PC LEGAL' => 'PC LEGAL',
                        'PC ADMIN LEGAL' => 'PC ADMIN LEGAL',
                        'PC ACCOUNTING' => 'PC ACCOUNTING',
                        'PC GUDANG JADI' => 'PC GUDANG JADI',
                        'PC ADMIN GUDANG JADI' => 'PC ADMIN GUDANG JADI',
                        'PC LABEL 1' => 'PC LABEL 1',
                        'PC LABEL 2' => 'PC LABEL 2',
                        'PC MARKING 1' => 'PC MARKING 1',
                        'PC MARKING 2' => 'PC MARKING 2',
                        'PC MARKING 3' => 'PC MARKING 3',
                        'PC RND' => 'PC RND',
                        'PC LASER' => 'PC LASER',
                        'PC GUDANG SETENGAH JADI' => 'PC GUDANG SETENGAH JADI',
                        'PC ADMIN PPIC' => 'PC ADMIN PPIC',
                        'PC GEDUNG 2' => 'PC GEDUNG 2',
                        'PC CNC MILLING' => 'PC CNC MILLING',
                        'PC CNC ROUTER' => 'PC CNC ROUTER',
                        // Tambahkan opsi lainnya sesuai kebutuhan
                    ])
                    ->required()
                    ->searchable(),        
                // Section untuk Backup Data
                Section::make('Backup Data')
                    ->schema([
                        DatePicker::make('backup_data_tanggal')
                            ->label('Tanggal Backup')
                            ->nullable(),
                        Checkbox::make('backup_data_checked')
                            ->label('Sudah Backup')
                            ->nullable(),
                    ])
                    ->columns(2), // Biar form rapi dua kolom

                // Section untuk Update Antivirus
                Section::make('Update Antivirus')
                    ->schema([
                        DatePicker::make('antivirus_update_tanggal')
                            ->label('Tanggal Update Antivirus')
                            ->nullable(),
                        Checkbox::make('antivirus_update_checked')
                            ->label('Sudah Update Antivirus')
                            ->nullable(),
                    ])
                    ->columns(2),

                // Section untuk Troubleshooting
                Section::make('Troubleshooting')
                    ->schema([
                        DatePicker::make('troubleshooting_tanggal')
                            ->label('Tanggal Troubleshooting')
                            ->nullable(),
                        Checkbox::make('troubleshooting_checked')
                            ->label('Sudah Troubleshooting')
                            ->nullable(),
                    ])
                    ->columns(2),
                // Section untuk Defragmentation
                Section::make('Defragmentation')
                    ->schema([
                        DatePicker::make('defragment_tanggal')
                            ->label('Tanggal Defragmentation')
                            ->nullable(),
                        Checkbox::make('defragment_checked')
                            ->label('Sudah Defragmentation')
                            ->nullable(),
                    ])
                    ->columns(2),
                Section::make('Keterangan')
                    ->schema([
                        Checkbox::make('has_keterangan')
                            ->label('Tambah Keterangan')
                            ->reactive(),
                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->nullable()
                            ->hidden(fn (callable $get) => ! $get('has_keterangan')),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('bulan')
                ->formatStateUsing(fn (int $state): string => Carbon::create()->month($state)->format('F'))
                ->sortable()
                ->searchable(),
                
                Tables\Columns\TextColumn::make('tahun')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('pengontrol')
                    ->formatStateUsing(function ($state) {
                        $names = [
                            'rochim.png' => 'RCHM',
                            'adit.png' => 'ADYP',
                            // Tambahkan opsi lainnya sesuai kebutuhan
                        ];
                        return $names[$state] ?? $state;
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->formatStateUsing(function ($state) {
                        $names = [
                            'PC HRD' => 'PC HRD',
                            'PC IT' => 'PC IT',
                            'PC PENJUALAN' => 'PC PENJUALAN',
                            'PC PENJUALAN 2' => 'PC PENJUALAN 2',
                            'PC ADMIN PENJUALAN' => 'PC ADMIN PENJUALAN',
                            'PC PURCHASING' => 'PC PURCHASING',
                            'PC LEGAL' => 'PC LEGAL',
                            'PC ADMIN LEGAL' => 'PC ADMIN LEGAL',
                            'PC ACCOUNTING' => 'PC ACCOUNTING',
                            'PC GUDANG JADI' => 'PC GUDANG JADI',
                            'PC ADMIN GUDANG JADI' => 'PC ADMIN GUDANG JADI',
                            'PC LABEL 1' => 'PC LABEL 1',
                            'PC LABEL 2' => 'PC LABEL 2',
                            'PC MARKING 1' => 'PC MARKING 1',
                            'PC MARKING 2' => 'PC MARKING 2',
                            'PC MARKING 3' => 'PC MARKING 3',
                            'PC RND' => 'PC RND',
                            'PC LASER' => 'PC LASER',
                            'PC GUDANG SETENGAH JADI' => 'PC GUDANG SETENGAH JADI',
                            'PC ADMIN PPIC' => 'PC ADMIN PPIC',
                            'PC GEDUNG 2' => 'PC GEDUNG 2',
                            'PC CNC MILLING' => 'PC CNC MILLING',
                            'PC CNC ROUTER' => 'PC CNC ROUTER',
                        ];
                        return $names[$state] ?? $state;
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('backup_data_tanggal')
                    ->date('d F Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('backup_data_checked')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Backup'),

                Tables\Columns\TextColumn::make('antivirus_update_tanggal')
                    ->date('d F Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('antivirus_update_checked')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Antivirus'),

                Tables\Columns\TextColumn::make('troubleshooting_tanggal')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('troubleshooting_checked')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Troubleshooting'),
                Tables\Columns\TextColumn::make('defragment_tanggal')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('defragment_checked')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Defragmentation'),
                Tables\Columns\TextColumn::make('keterangan')
                    ->limit(50)
                    ->wrap()
                    ->toggleable()
                    ->searchable(),
                
            ])
            ->defaultSort('bulan', 'desc')
            ->filters([
                //
             
                Tables\Filters\SelectFilter::make('tahun')
                    ->options(collect(range(now()->year - 5, now()->year + 5))->mapWithKeys(fn ($year) => [
                        $year => $year
                    ]))
                    ->label('Tahun'),
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                
                
            ])
            ->headerActions([
                Tables\Actions\Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->form([
                        Select::make('tahun')
                            ->label('Pilih Tahun')
                            ->options(collect(range(now()->year - 5, now()->year + 5))->mapWithKeys(fn ($year) => [
                                $year => $year
                            ]))
                            ->default(now()->year)
                            ->required(),
                        Select::make('nama')
                            ->label('Pilih Nama')
                            ->options([
                                'PC HRD' => 'PC HRD',
                                'PC IT' => 'PC IT',
                                'PC PENJUALAN' => 'PC PENJUALAN',
                                'PC PENJUALAN 2' => 'PC PENJUALAN 2',
                                'PC ADMIN PENJUALAN' => 'PC ADMIN PENJUALAN',
                                'PC PURCHASING' => 'PC PURCHASING',
                                'PC LEGAL' => 'PC LEGAL',
                                'PC ADMIN LEGAL' => 'PC ADMIN LEGAL',
                                'PC ACCOUNTING' => 'PC ACCOUNTING',
                                'PC FINANCE' => 'PC FINANCE',
                                'PC ADMIN FINANCE' => 'PC ADMIN FINANCE',
                                'PC GUDANG JADI' => 'PC GUDANG JADI',
                                'PC ADMIN GUDANG JADI' => 'PC ADMIN GUDANG JADI',
                                'PC LABEL 1' => 'PC LABEL 1',
                                'PC LABEL 2' => 'PC LABEL 2',
                                'PC MARKING 1' => 'PC MARKING 1',
                                'PC MARKING 2' => 'PC MARKING 2',
                                'PC MARKING 3' => 'PC MARKING 3',
                                'PC RND' => 'PC RND',
                                'PC LASER' => 'PC LASER',
                                'PC GUDANG SETENGAH JADI' => 'PC GUDANG SETENGAH JADI',
                                'PC ADMIN PPIC' => 'PC ADMIN PPIC',
                                'PC GEDUNG 2' => 'PC GEDUNG 2',
                                'PC CNC MILLING' => 'PC CNC MILLING',
                                'PC CNC ROUTER' => 'PC CNC ROUTER',
                            ])
                            ->required()
                            ->searchable(),
                    ]) ->action(function (array $data) {
                        // Redirect to the print route with selected parameters
                        return redirect()->route('pengendalian-sistem.print', [
                            'tahun' => $data['tahun'],
                            'nama' => $data['nama'],
                        ]);
                    }),
                    
                    
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
            'index' => Pages\ListPengendalianSitemITS::route('/'),
            'create' => Pages\CreatePengendalianSitemIT::route('/create'),
            'edit' => Pages\EditPengendalianSitemIT::route('/{record}/edit'),
        ];
    }    
}
