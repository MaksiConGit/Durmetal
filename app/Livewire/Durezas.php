<?php

namespace App\Livewire;

use App\Models\Dureza;
use Livewire\Component;
use Illuminate\Database\QueryException;

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

        try {
            $dureza = Dureza::find($id);

            if ($dureza) {
                $dureza->delete();
            }

            $this->durezas = Dureza::all();

            $this->selectedDureza = Dureza::first();
            $this->selectedItem = $this->selectedDureza?->id;

        } catch (QueryException $e) {

            // Código 1451 = foreign key constraint
            if ($e->errorInfo[1] == 1451) {

                session()->flash('error', 'No se puede eliminar la dureza porque hay items que la están usando.');

            } else {
                throw $e; // otro error, lo dejamos explotar
            }
        }
    }

    public function render()
    {
        return view('livewire.durezas');
    }
}
