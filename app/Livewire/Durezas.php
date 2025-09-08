<?php

namespace App\Livewire;

use App\Models\Dureza;
use Livewire\Component;

class Durezas extends Component
{
    public $durezas;
    public $selectedDureza;
    public $selectedItem = null;

    public function mount()
    {
        $this->durezas = Dureza::all();

        if (session('dureza_id')) {
            $this->selectedDureza = Dureza::find(session('dureza_id'));
        }
        else{
            $this->selectedDureza = Dureza::first();
        }
    }

    public function selectItem($id)
    {
        $this->selectedItem = $id;
        $this->selectedDureza = Dureza::find($this->selectedItem);
    }

    public function deleteItem($id)
    {
        if (!$id) return;

        $dureza = Dureza::find($id);
        if ($dureza) {
            $dureza->delete();
            $this->selectedItem = null;
            $this->durezas = Dureza::all();
        }
    }

    public function render()
    {
        return view('livewire.durezas');
    }
}
