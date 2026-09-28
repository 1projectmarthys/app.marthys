<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CurrencyInput extends Component
{

    public $value; 
    public $currency = 'IDR';
    public $fieldId;
    protected $listeners = ['currencyChanged'];

    public function mount($value = 0, $fieldId = null)
    {
        $this->value = $value;
        $this->fieldId = $fieldId;
    }

    public function currencyChanged($currency)
    {
        $this->currency = $currency;
    }

    public function getFormattedValueProperty()
    {
        $symbol = match($this->currency) {
            'USD' => '$ ',
            'IDR' => 'Rp ',
            'CNY' => '¥ ',
            default => 'Rp '
        };
        return $symbol . number_format(floatval($this->value), 2, '.', ',');
    }
    public function render()
    {
        return view('livewire.currency-input');
    }
}
