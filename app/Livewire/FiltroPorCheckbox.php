<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use Livewire\Component;

class FiltroPorCheckbox extends Component
{
    public $selectedIds = [];
    public $selectedItemIds = [];

    public function getItemsProperty()
    {
        $estadosPermitidos = ['PENDIENTE', 'APROBADO'];

        if (empty($this->selectedIds)) {
            return ItemOrdenTrabajo::whereIn('Estado', $estadosPermitidos)->get();
        }

        $selectedItems = collect();
        if (!empty($this->selectedItemIds)) {
            $selectedItems = ItemOrdenTrabajo::whereIn('id', $this->selectedItemIds)
                ->whereIn('Estado', $estadosPermitidos)
                ->get();
        }

        $filteredItems = ItemOrdenTrabajo::whereIn('IdTratamiento', $this->selectedIds)
            ->whereIn('Estado', $estadosPermitidos)
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
