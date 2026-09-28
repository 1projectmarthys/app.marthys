<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengajuanpembayaranResource\Pages;
use App\Models\Pengajuanpembayaran;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;

class PengajuanpembayaranResource extends Resource
{
    protected static ?string $model = Pengajuanpembayaran::class;
    protected static ?string $navigationGroup = 'Accounting';
    protected static ?string $navigationLabel = 'Pengajuan Pembayaran';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
   

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('nomor_dokumen')
                ->label('Nomor Dokumen')
                ->disabled(),

                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->label('Tanggal'),
            ]),
                Forms\Components\TextInput::make('nama_supplier')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Supplier'),

                Forms\Components\TextInput::make('sumber_dana')
                    ->required()
                    ->maxLength(255)
                    ->label('Sumber Dana'),
            forms\Components\Grid::make(2)->schema([
                
               
                Forms\Components\Select::make('mata_uang')
                    ->options([
                        'IDR' => 'IDR',
                        'USD' => 'USD',
                        'CNY' => 'CNY'
                    ])
                    ->default('IDR')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $grandTotal = floatval($get('grand_total') ?? 0);
                        $symbol = match($state) {
                            'USD' => '$ ',
                            'IDR' => 'Rp ',
                            'CNY' => '¥ ',
                            default => 'Rp '
                        };
                        $set('grand_total', $symbol . number_format($grandTotal, 2, '.', ','));
                    })
                    ->label('Mata Uang'),
                    Forms\Components\DatePicker::make('rencana_bayar')
                    ->required()
                    ->label('Rencana Bayar'),
                    Forms\Components\TextInput::make('kurs')
                    ->mask(fn ($mask) => $mask->numeric()->thousandsSeparator(','))
                    ->default(1)
                    ->label('Kurs')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $kurs = floatval(str_replace(',', '', $state ?? 1));
                        $grandTotal = floatval($get('grand_total') ?? 0);
                        $grandTotalWithKurs = $grandTotal * $kurs;
                        
                        // Update potongan calculations with new grand total
                        $tipePotongan = $get('tipe_potong');
                        $potonganHarga = floatval($get('potongan_harga') ?? 0);
                        
                        if ($tipePotongan === 'on_net_total') {
                            $totalPotongan = $grandTotalWithKurs - ($grandTotalWithKurs * ($potonganHarga / 100));
                        } else {
                            $totalPotongan = $grandTotalWithKurs - $potonganHarga;
                        }
                        
                        $set('total_potongan', $totalPotongan);
                        $set('total_bayar',  'Rp ' . number_format($totalPotongan, 2, '.', ','));
                    }),
                 
            ]),
            

           
           
                // Tambahkan Repeater di sini
            Forms\Components\Repeater::make('detail_pengajuan')
                ->label('Detail Pengajuan')
                ->relationship()   
                ->schema([
                    Grid::make(4)->schema([
                          // Ubah jumlah kolom menjadi 5 agar semua inputan berada dalam satu baris
                        
                           
                        Forms\Components\DatePicker::make('tanggal_dokumen')
                            ->label('Tanggal')
                            ->required(),
            
                        Forms\Components\TextInput::make('uraian')
                            ->label('No Faktur')
                            ->required(),

                       Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->mask(fn ($mask) => $mask->numeric()->thousandsSeparator(','))
                            ->required()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Calculate grand total when jumlah changes
                                $items = $get('../../detail_pengajuan');
                                $grandTotal = collect($items)->sum(fn ($item) => 
                                    floatval(str_replace(',', '', $item['jumlah'] ?? 0))
                                );
                                $set('../../grand_total', $grandTotal);
                                
                                // Recalculate final total
                                $tipePotongan = $get('../../tipe_potong');
                                $potonganHarga = floatval($get('../../potongan_harga') ?? 0);
                                
                                if ($tipePotongan === 'on_net_total') {
                                    $totalPotongan = $grandTotal - ($grandTotal * ($potonganHarga / 100));
                                } else {
                                    $totalPotongan = $grandTotal - $potonganHarga;
                                }
                                
                                $set('../../total_potongan', $totalPotongan);
                                $set('../../total_bayar', 'Rp ' . number_format($totalPotongan, 2, '.', ','));
                            }),
                          
                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(1), // Atur jumlah baris teks area agar lebih kecil
                    ]),
                ])
                ->defaultItems(1) // Default satu item
                ->createItemButtonLabel('Tambah Penagihan') // Tombol tambah item
                ->columns(1) // Pastikan repeater memiliki 1 kolom
                ->required()
                ->reactive(),
            Forms\Components\Select::make('status_bayar')
                ->label('Status Bayar')
                ->options([
                    'pending' => 'Pending',
                    'completed' => 'Completed',
                    'processed' => 'Processed',
                ])
                ->required(),
            Forms\Components\Select::make('jumlah_kolom')
                    ->options([
                        '3kolom' => '3 Kolom',
                        '4kolom' => '4 Kolom'
                    ])
                ->default('3 kolom')
                ->label('Jumlah Kolom')
                ->reactive(),
             
            Forms\Components\Select::make('tipe_potong')
                ->options([
                    'actual' => 'Actual',
                    'on_net_total' => 'On Net Total'
                ])
            
                ->label('Tipe Potongan')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $grandTotal = floatval($get('grand_total') ?? 0);
                    $potonganHarga = floatval($get('potongan_harga') ?? 0);
                    
                    if ($state === 'on_net_total') {
                        $totalPotongan = $grandTotal - ($grandTotal * ($potonganHarga / 100));
                    } else {
                        $totalPotongan = $grandTotal - $potonganHarga;
                    }
                    
                    $set('total_potongan', $totalPotongan);
                    $set('total_bayar', $totalPotongan);
                }),

            Forms\Components\TextInput::make('keterangan_potong')
                ->maxLength(65535)
                ->label('Keterangan Potongan'),

           
            Forms\Components\TextInput::make('potongan_harga')
                ->label('Potongan Harga')
                ->numeric()
                ->default(0)
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $kurs = floatval(str_replace(',', '', $get('kurs') ?? 1));
                    $grandTotal = floatval($get('grand_total') ?? 0);
                    $grandTotalWithKurs = $grandTotal * $kurs;
                    
                    $tipePotongan = $get('tipe_potong');
                    $potonganHarga = floatval($state ?? 0);
                    
                    if ($state == 0) {
                        // When no discount is applied, only consider amount and exchange rate
                        $totalBayarIDR = $grandTotalWithKurs;
                        $totalPotongan = $grandTotalWithKurs;
                    } else {
                        // When discount is applied
                        if ($tipePotongan === 'on_net_total') {
                            $totalPotongan = $grandTotalWithKurs - ($grandTotalWithKurs * ($potonganHarga / 100));
                        } else {
                            $totalPotongan = $grandTotalWithKurs - $potonganHarga;
                        }
                        $totalBayarIDR = $totalPotongan;
                    }
                    
                    $set('total_potongan', $totalPotongan);
                    $set('total_bayar', 'Rp ' . number_format($totalBayarIDR, 2, '.', ','));
                }),

            Forms\Components\TextInput::make('grand_total')
                ->label('Grand Total')
                ->disabled()
                ->numeric(),

            Forms\Components\TextInput::make('total_bayar')
                ->label('Total Bayar (IDR)')
                ->disabled(),

          

           
           

            
             
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
              
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->sortable()
                    ->searchable(), 
              
                Tables\Columns\TextColumn::make('nomor_dokumen')
                    ->label('Nomor Dokumen')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('tanggal')
                    ->date('d-m-Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('nama_supplier')
                    ->label('Nama Supplier')
                    ->sortable()
                    ->searchable()
                    ->color('success'),

                Tables\Columns\TextColumn::make('total_bayar')
                    ->label('Total Bayar')
                    ->sortable()
                  
                    ->money('IDR')
                    ->searchable(),
                
                Tables\Columns\BadgeColumn::make('status_bayar')
                    ->colors([
                        'danger' => 'pending',
                        'warning' => 'processed',
                        'success' => 'completed',
                    ])
                    ->label('Status')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('terbayar')
                ->label('Terbayar')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record) => $record->status_bayar !== 'completed')
                ->action(function ($record) {
                    $record->update([
                        'status_bayar' => 'completed'
                    ]);
                    Notification::make()
                        ->success()
                        ->title('Status pembayaran berhasil diupdate')
                        ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Pembayaran')
                ->modalSubheading('Apakah Anda yakin ingin menandai pembayaran ini sebagai terbayar?')
                ->modalButton('Ya, Tandai Sebagai Terbayar'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->url(fn ($record) => route('print.pembayaran', $record->id)) // URL ke route print
                ->openUrlInNewTab(), // Buka di tab baru
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
            'index' => Pages\ListPengajuanpembayarans::route('/'),
            'create' => Pages\CreatePengajuanpembayaran::route('/create'),
            'edit' => Pages\EditPengajuanpembayaran::route('/{record}/edit'),
        ];
    }    
}
