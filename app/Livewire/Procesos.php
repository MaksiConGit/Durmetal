<?php

namespace App\Livewire;

use App\Models\TipoProgramacion;
use Livewire\Component;

class Procesos extends Component
{
    public $procesos;
    public $selectedProceso;
    public $selectedItem = null;

    public function mount()
    {
        $this->procesos = TipoProgramacion::all();

        if (session('proceso_id')) {
            $this->selectedProceso = TipoProgramacion::find(session('proceso_id'));
        }
        else{
            $this->selectedProceso = TipoProgramacion::first();
        }
    }

    public function selectItem($id)
    {
        $this->selectedItem = $id;
        $this->selectedProceso = TipoProgramacion::find($this->selectedItem);
    }

    public function deleteItem($id)
    {
        if (!$id) return;

        $proceso = TipoProgramacion::find($id);
        if ($proceso) {
            $proceso->delete();
            $this->selectedItem = null;
            $this->procesos = TipoProgramacion::all();
        }
    }

    public function render()
    {
        return view('livewire.procesos');
    }
}
