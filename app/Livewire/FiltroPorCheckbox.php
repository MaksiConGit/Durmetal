<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use Livewire\Component;

class FiltroPorCheckbox extends Component
{
    public $selectedIds = [];

    public $tratamientos = [];
    public $items_orden_trabajo = [];

    public function mount($tratamientos, $items_orden_trabajo)
    {
        $this->tratamientos = $tratamientos;
        $this->items_orden_trabajo = $items_orden_trabajo;
    }

    public function getItemsProperty()
    {
        if (empty($this->selectedIds)) {
            return ItemOrdenTrabajo::all();
        }

        return ItemOrdenTrabajo::whereIn('IdTratamiento', $this->selectedIds)->get();
    }

    public function render()
    {
        return view('livewire.filtro-por-checkbox');
    }
}
