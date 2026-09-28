<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PengajuanCalculator extends Component
{
    public $grandTotal = 0;
    public $totalBayar = 0;
    
    protected $listeners = ['calculateTotals'];

    public function calculateTotals($items, $kurs, $potonganHarga, $mataUang)
    {
        $total = collect($items)->sum(fn($item) => 
            floatval(str_replace(',', '', $item['jumlah'] ?? 0))
        );

        // $symbol = match($mataUang) {
        //     'USD' => '$ ',
        //     'CNY' => '¥ ',
        //     default => 'Rp '
        // };

        // $this->grandTotal = $symbol . number_format($total, 2, '.', ',');
        $this->grandTotal = number_format($total, 2, '.', ',');
        $this->totalBayar = 'Rp ' . number_format(($total * $kurs) - $potonganHarga, 2, '.', ',');
    }

    public function render()
    {
        return view('livewire.pengajuan-calculator');
    }
}
