<?php

namespace App\Livewire;

use App\Models\Tratamiento;
use Livewire\Component;

class Tratamientos extends Component
{
    public $tratamientos;
    public $selectedTratamiento;
    public $selectedItem = null;

    public function mount()
    {
        $this->tratamientos = Tratamiento::all();

        if (session('tratamiento_id')) {
            $this->selectedTratamiento = Tratamiento::find(session('tratamiento_id'));
        }
        else{
            $this->selectedTratamiento = Tratamiento::first();
        }
    }

    public function selectItem($id)
    {
        $this->selectedItem = $id;
        $this->selectedTratamiento = Tratamiento::find($this->selectedItem);
    }

    public function deleteItem($id)
    {
        if (!$id) return;

        $dureza = Tratamiento::find($id);
        if ($dureza) {
            $dureza->delete();
            $this->selectedItem = null;
            $this->tratamientos = Tratamiento::all();
        }
    }

    public function render()
    {
        return view('livewire.tratamientos');
    }
}
