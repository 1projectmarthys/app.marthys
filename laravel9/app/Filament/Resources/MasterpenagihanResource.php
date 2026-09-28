<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MasterpenagihanResource\Pages;
use App\Filament\Resources\MasterpenagihanResource\RelationManagers;
use App\Models\Masterpenagihan;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class MasterpenagihanResource extends Resource
{
    protected static ?string $model = Masterpenagihan::class;
    protected static ?string $navigationGroup = 'Penjualan';
protected static ?string $navigationLabel = 'Master Penagihan';
protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static string $view = 'vendor.filament.penagihan.inputpenagihan';

    protected static function getCustomerData()
    {
        return [
            'PT. Darmawangsa Medical Supplies' => [
                'address' => 'Jl. Darmawangsa No. 123, Jakarta',
                'code' => 'DMS-001'
            ],
            'PT. Avia Dinamika Mandiri' => [
                'address' => 'Jl. Avia Mandiri No. 45, Surabaya',
                'code' => 'ADM-001'
            ],
            'PT. Trinusa Darma Satha' => [
                'address' => 'Jl. Trinusa No. 67, Bandung',
                'code' => 'TDS-001'
            ],
            'PT. Syaharani' => [
                'address' => 'Jl. Syaharani No. 89, Medan',
                'code' => 'SYH-001'
            ],
            'PT. Karunia Abadi Indonesia' => [
                'address' => 'Jl. Karunia No. 123, Semarang',
                'code' => 'KAI-001'
            ],
            'PT. Djama Mulia Bersaudara' => [
                'address' => 'Jl. Djama Mulia No. 45, Makassar',
                'code' => 'DMB-001'
            ],
            'PT. Multi Axis Surgical' => [
                'address' => 'Jl. Multi Axis No. 78, Surabaya',
                'code' => 'MAS-001'
            ],
            'PT. Andalan Bisturi Pratama' => [
                'address' => 'Jl. Andalan No. 90, Jakarta',
                'code' => 'ABP-001'
            ]
        ];
    }
    public static function form(Form $form): Form
    {
        $customerData = static::getCustomerData();
        return $form
            ->schema([
                //
                Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\TextInput::make('nomor_dokumen')
                        ->label('Nomor Dokumen')
                        ->disabled(),
                    
                    Forms\Components\DatePicker::make('tanggal_dokumen')
                        ->label('Tanggal Dokumen')
                        ->required(),
                ]),

            Forms\Components\Select::make('nama_customer')
                ->label('Nama Customer')
                ->required()
                ->options([
                    ' PT. Darmawangsa Medical Supplies' => 'PT. Darmawangsa Medical Supplies',
                    ' PT. Avia Dinamika Mandiri' => ' PT. Avia Dinamika Mandiri',
                    ' PT. Trinusa Darma Satha' => 'PT. Trinusa Darma Satha',
                    ' PT. Syaharani' => ' PT. Syaharani',
                    ' PT. Karunia Abadi Indonesia' => ' PT. Karunia Abadi Indonesia',
                    ' PT. Multi Axis Surgical' => ' PT. Multi Axis Surgical',
                    // ' PT. Andalan Bisturi Pratama' => ' PT. Andalan Bisturi Pratama',  
                    // ' PT. Djama Mulia Bersaudara' => ' PT. Djama Mulia Bersaudara',  
                ]),
                
                Forms\Components\Select::make('alamat_customer')
                    ->label('Nama Customer')
                    ->required()
                    ->options([
                      'Jl. Comal No.8, Keputran, Kec. Tegalsari'=>'Jl. Comal No.8, Keputran, Kec. Tegalsari - PT. Darmawangsa Medical Supplies ', 
                      'Jl. Pesona Alam Gunung Anyar S-6 Surabaya'=>'Jl. Pesona Alam Gunung Anyar S-6 Surabaya - PT. Avia Dinamika Mandiri',
                      'JL. TUKAD BARITO TIMUR NO. 8, DENPASAR- BALI'=>'JL. TUKAD BARITO TIMUR NO. 8, DENPASAR- BALI - PT. Trinusa Darma Satha',   
                      'Jl. Manyar Sambongan no.111 B Surabaya'=>'Jl. Manyar Sambongan no.111 B Surabaya - PT. Syaharani',
                      'JL. Dukuh Kupang timur VII / 36 Surabaya'=>'JL. Dukuh Kupang timur VII / 36 Surabaya - PT. Karunia Abadi Indonesia',
                      'Jl. Arief Rahman Hakim 138-142 Perumahan Regency 21 Blok E/2 Surabaya'=>'Jl. Arief Rahman Hakim 138-142 Perumahan Regency 21 Blok E/2 Surabaya - PT. MULTI AXIS SURGICAL',
                    ]),
            // Forms\Components\TextInput::make('alamat_customer')
            // ->label('Alamat Customer')
            // ->required(),
          
            Forms\Components\TextInput::make('kode_customer')
                ->label('Kode Customer')
                ->required(),
            Forms\Components\Textarea::make('keterangan_lengkap')
                ->label('Keterangan Lengkap'),
            Forms\Components\Select::make('status_bayar')
                ->label('Status Bayar')
                ->options([
                    'pending' => 'Pending',
                    'completed' => 'Completed',
                    'canceled' => 'Canceled',
                ])
                ->required(),
          
                     // Tambahkan Repeater di sini
                     Forms\Components\Repeater::make('detail_penagihan')
                     ->label('Detail Penagihan')
                     ->relationship()   
                     ->schema([
                         Grid::make(5)->schema([ // Ubah jumlah kolom menjadi 5 agar semua inputan berada dalam satu baris
                             Forms\Components\DatePicker::make('tanggal')
                                 ->label('Tanggal')
                                 ->required(),
                 
                             Forms\Components\TextInput::make('no_faktur')
                                 ->label('No Faktur')
                                 ->required(),
                 
                             Forms\Components\TextInput::make('no_faktur_pajak')
                                 ->label('No Faktur Pajak')
                                 ->required(),
                 
                            Forms\Components\TextInput::make('jumlah')
                                 ->label('Jumlah')
                                 ->mask(fn ($mask) => $mask->numeric()->thousandsSeparator(','))
                                 ->required()
                                 ->prefix('Rp')
                                 ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                     $items = $get('../../detail_penagihan');
                                     $grandTotal = collect($items)->sum(fn ($item) => floatval(str_replace(',', '', $item['jumlah'] ?? 0)));
                                     $set('../../total_tagihan', number_format($grandTotal, 2, '.', ''));
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
                     ->reactive()
                     ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $items = $get('../../detail_penagihan') ?? [];
                        $grandTotal = collect($items)->sum(function ($item) {
                            return isset($item['jumlah']) ? floatval(str_replace(',', '', $item['jumlah'])) : 0;
                        });
                        $set('../../total_tagihan', number_format($grandTotal, 2, '.', ''));
                    }),
                     
                    
                     Forms\Components\TextInput::make('total_tagihan')
                        ->label('Grand Total')
                        ->disabled()
                        ->default('0.00') // Nilai awal 0.00
                        ->prefix('Rp ')
                        ->reactive()
                        ->mask(fn ($mask) => $mask
                            ->numeric()
                            ->thousandsSeparator(',')
                            ->decimalSeparator('.')
                            ->decimalPlaces(2)
                        )
                        ->dehydrated(true),
            ])
            ->columns(1);
            
    }
   
    public static function afterSave(Model $record, array $data): void
{
    // Log data dari repeater
    Log::info('Data Repeater:', $data['detail_penagihan'] ?? []);

    // Hapus data lama di tabel detail_penagihan
    $record->detail_penagihan()->delete();

    // Simpan data baru dari repeater
    if (isset($data['detail_penagihan']) && is_array($data['detail_penagihan'])) {
        foreach ($data['detail_penagihan'] as $item) {
            Log::info('Menyimpan Item:', $item); // Log setiap item yang disimpan
            $record->detail_penagihan()->create([
                'tanggal' => $item['tanggal'],
                'no_faktur' => $item['no_faktur'],
                'no_faktur_pajak' => $item['no_faktur_pajak'],
                'jumlah' => $item['jumlah'],
                'keterangan' => $item['keterangan'],
            ]);
        }
    }

    // Update total_tagihan setelah detail_penagihan disimpan
    $grandTotal = $record->detail_penagihan->sum('jumlah');
    $record->update(['total_tagihan' => $grandTotal]);
}
    
    public static function afterEdit(Model $record, array $data): void
    {
        // Hapus data lama di tabel detail_penagihan
        $record->detail_penagihan()->delete();
    
        // Simpan data baru dari repeater
        if (isset($data['detail_penagihan'])) {
            foreach ($data['detail_penagihan'] as $item) {
                $record->detail_penagihan()->create([
                    'tanggal' => $item['tanggal'],
                    'no_faktur' => $item['no_faktur'],
                    'no_faktur_pajak' => $item['no_faktur_pajak'],
                    'jumlah' => $item['jumlah'],
                    'keterangan' => $item['keterangan'],
                ]);
            }
        }
    
        // Update total_tagihan setelah detail_penagihan disimpan
        $grandTotal = $record->detail_penagihan->sum('jumlah');
        $record->update(['total_tagihan' => $grandTotal]);
    }
    public static function table(Table $table): Table
    {
        return $table
        
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_dokumen')
                    ->label('Nomor Dokumen')
                    ->sortable()
                    ->searchable()
                    ->disabled(), // Nonaktifkan input manual
                
                Tables\Columns\TextColumn::make('tanggal_dokumen')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
             
                Tables\Columns\BadgeColumn::make('nama_customer')
                    ->label('Nama Customer')
                    ->enum([
                        'PT. Darmawangsa Medical Supplies' => 'PT. Darmawangsa Medical Supplies',
                        ' PT. Avia Dinamika Mandiri' => ' PT. Avia Dinamika Mandiri',
                        'PT. Trinusa Darma Satha' => 'PT. Trinusa Darma Satha',
                        ' PT. Syaharani' => ' PT. Syaharani',
                        ' PT. Karunia Abadi Indonesia' => ' PT. Karunia Abadi Indonesia',
                        ' PT. Karunia Abadi Indonesia' => ' PT. Karunia Abadi Indonesia',
                        ' PT. Djama Mulia Bersaudara' => ' PT. Djama Mulia Bersaudara',
                        ' PT. Multi Axis Surgical' => ' PT. Multi Axis Surgical',
                        ' PT. Andalan Bisturi Pratama' => ' PT. Andalan Bisturi Pratama',    
                    ])
                    ->sortable()
                    ->searchable()
                    ->color('success'),
                Tables\Columns\TextColumn::make('keterangan_lengkap')
                    ->label('Keterangan')
                    ->limit(50),
                Tables\Columns\BadgeColumn::make('status_bayar')
                    ->label('Status')
                    ->enum([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ])
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'completed',
                        'danger' => 'canceled',
                    ]),
                Tables\Columns\TextColumn::make('total_tagihan')
                    ->label('Total Tagihan')
                    ->prefix('Rp ')
                    ->sortable(),
                
                    
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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
                ->url(fn ($record) => route('print.penagihan', $record->id)) // URL ke route print
                ->openUrlInNewTab(), // Buka di tab baru
                Tables\Actions\Action::make('Print Kwitansi')
                ->label('Print Kwitansi')
                ->icon('heroicon-o-printer') 
                ->url(fn ($record) => route('print.kwitansi', $record->id)) // URL ke route print   
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
            'index' => Pages\ListMasterpenagihans::route('/'),
            'create' => Pages\CreateMasterpenagihan::route('/create'),
            'edit' => Pages\EditMasterpenagihan::route('/{record}/edit'),
        ];
    }    
}
