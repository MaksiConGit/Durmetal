<?php

namespace App\Livewire;

use App\Models\FactorPremio;
use Livewire\Component;

class FactoresPremio extends Component
{
    public $factores_premio;
    public $selectedFactor;
    public $selectedItem = null;

    public function mount()
    {
        $this->factores_premio = FactorPremio::all();

        if (session('factor_premio_id')) {
            $this->selectedFactor = FactorPremio::find(session('factor_premio_id'));
        }
        else{
            $this->selectedFactor = FactorPremio::first();
        }
    }

    public function selectItem($id)
    {
        $this->selectedItem = $id;
        $this->selectedFactor = FactorPremio::find($this->selectedItem);
    }

    public function deleteItem($id)
    {
        if (!$id) return;

        $factor_premio = FactorPremio::find($id);
        if ($factor_premio) {
            $factor_premio->delete();
            $this->selectedItem = null;
            $this->factores_premio = FactorPremio::all();
        }
    }

    public function render()
    {
        return view('livewire.factores-premio');
    }
}
