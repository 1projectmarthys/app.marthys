<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtimatikaResource\Pages;
use App\Filament\Resources\ArtimatikaResource\RelationManagers;
use App\Models\Artimatika;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtimatikaResource extends Resource
{
    protected static ?string $model = Artimatika::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Repeater::make('daftar_barang')
            ->label('Daftar Barang')
            ->schema([
                Grid::make(4)->schema([
                    TextInput::make('nama_barang')
                        ->label('Nama Barang')
                        ->required(),

                    TextInput::make('jumlah')
                        ->label('Jumlah')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            $harga = (float) $get('harga_satuan');
                            $set('total_harga', $state * $harga);

                            // Hitung grand total dari total_harga semua item
                            $items = $get('../../daftar_barang');
                            $grandTotal = collect($items)->sum('total_harga');
                            $set('../../grand_total', $grandTotal);
                        }),

                    TextInput::make('harga_satuan')
                        ->label('Harga Satuan')
                        ->mask(fn ($mask) => $mask->numeric()->thousandsSeparator(','))
                        // ->numeric()
                        ->required()
                        ->reactive()
                        
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            $jumlah = (float) $get('jumlah');
                            $set('total_harga', $jumlah * $state);

                            // Hitung grand total dari total_harga semua item
                            $items = $get('../../daftar_barang');
                            $grandTotal = collect($items)->sum('total_harga');
                            $set('../../grand_total', $grandTotal);
                        }),

                    TextInput::make('total_harga')
                        ->label('Total Harga')
                        ->numeric()
                        ->disabled()
                        ->prefix('Rp')
                        ->dehydrated(true),
                ]),
            ])
            ->defaultItems(1)
            ->createItemButtonLabel('Tambah Barang')
            ->columns(1)
            ->reactive()
            ->afterStateUpdated(function (callable $set, callable $get) {
                // Ini juga penting: ketika nambah/hapus item
                $items = $get('daftar_barang');
                $grandTotal = collect($items)->sum('total_harga');
                $set('grand_total', $grandTotal);
            }),

        TextInput::make('grand_total')
            ->label('Grand Total')
            ->numeric()
            ->disabled()
            ->reactive()
            ->prefix('Rp')
            ->dehydrated(true), // kalau mau disimpan ke database, set true
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable(),       
                Tables\Columns\TextColumn::make('harga_satuan')
                    ->label('Harga Satuan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListArtimatikas::route('/'),
            'create' => Pages\CreateArtimatika::route('/create'),
            'edit' => Pages\EditArtimatika::route('/{record}/edit'),
        ];
    }    
}
