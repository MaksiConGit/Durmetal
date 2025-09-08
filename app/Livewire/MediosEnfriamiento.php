<?php

namespace App\Livewire;

use App\Models\MedioEnfriamiento;
use Livewire\Component;

class MediosEnfriamiento extends Component
{
    public $medios_enfriamiento;
    public $selectedMedio;
    public $selectedItem = null;

    public function mount()
    {
        $this->medios_enfriamiento = MedioEnfriamiento::all();

        if (session('medio_enfriamiento_id')) {
            $this->selectedMedio = MedioEnfriamiento::find(session('medio_enfriamiento_id'));
        }
        else{
            $this->selectedMedio = MedioEnfriamiento::first();
        }
    }

    public function selectItem($id)
    {
        $this->selectedItem = $id;
        $this->selectedMedio = MedioEnfriamiento::find($this->selectedItem);
    }

    public function deleteItem($id)
    {
        if (!$id) return;

        $medio_enfriamiento = MedioEnfriamiento::find($id);
        if ($medio_enfriamiento) {
            $medio_enfriamiento->delete();
            $this->selectedItem = null;
            $this->medios_enfriamiento = MedioEnfriamiento::all();
        }
    }

    public function render()
    {
        return view('livewire.medios-enfriamiento');
    }
}
