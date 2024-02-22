<?php

namespace App\Http\Livewire;

use App\Modules\Parameters\Repositories\CurrencyValueInterface;
use Livewire\Component;

class CurrencyValue extends Component
{
    protected $currencyvalue;

    public $currencyvalue_rate;
    /*
      Special Syntax: ['echo:{channel},{event}' => '{method}']
    */

    protected $listeners = ['currencyValue' => 'currencyValueRate'];

    public function mount(CurrencyValueInterface $currencyvalue)
    {
        $this->model = $currencyvalue;
    }

    /**************************************************************************/
    public function render()
    {
        return view('livewire.currency-value');
    }

    /**************************************************************************/
    public function currencyValueRate()
    {
        $this->currencyvalue_rate = $this->model->getLast();
    }
}
