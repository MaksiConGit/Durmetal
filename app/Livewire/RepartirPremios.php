<?php

namespace App\Livewire;

use App\Models\Premio;
use Livewire\Component;

class RepartirPremios extends Component
{
    public $premios;
    public $selectedPremio;
    public $selectedItem = null;
    public $expanded = [];

    public function mount()
    {
        $this->premios = Premio::all();

        if (session('premio_id')) {
            $this->selectedPremio = Premio::find(session('premio_id'));
        }
        else{
            $this->selectedPremio = Premio::first();
        }
    }

    public function selectAndExpand($id)
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            $this->expanded[] = $id;
        }

        $this->selectedItem = $id;
        $this->selectedPremio = Premio::find($this->selectedItem);
    }

    public function deleteItem($id)
    {
        if (!$id) return;

        $premio = Premio::find($id);
        if ($premio) {
            $premio->delete();
            $this->selectedItem = null;
            $this->premios = Premio::all();
        }
    }

    public function render()
    {
        return view('livewire.repartir-premios', [
            'expanded' => $this->expanded,
        ]);
    }
}
