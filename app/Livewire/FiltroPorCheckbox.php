<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use Livewire\Component;

class FiltroPorCheckbox extends Component
{
    public $selectedIds = [];
    public $selectedItemIds = [];

    // public function updatedSelectedItemIds()
    // {
    //     dd($this->selectedItemIds);
    // }

public function getItemsProperty()
{
    // No hay filtros => mostrar todos los ítems
    if (empty($this->selectedIds)) {
        return ItemOrdenTrabajo::all();
    }

    // Hay filtros => aplicar lógica de anteponer seleccionados
    $selectedItems = collect();
    if (!empty($this->selectedItemIds)) {
        $selectedItems = ItemOrdenTrabajo::whereIn('id', $this->selectedItemIds)->get();
    }

    $filteredItems = ItemOrdenTrabajo::whereIn('IdTratamiento', $this->selectedIds)
        ->when(!empty($this->selectedItemIds), function ($query) {
            return $query->whereNotIn('id', $this->selectedItemIds);
        })
        ->get();

    return $selectedItems->concat($filteredItems);
}


    public function render()
    {
        return view('livewire.filtro-por-checkbox', [
            'tratamientos' => Tratamiento::all(),
            'items' => $this->items,
        ]);
    }
}