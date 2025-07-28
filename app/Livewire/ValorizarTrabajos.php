<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use App\Models\Client;
use Livewire\Component;

class ValorizarTrabajos extends Component
{
    public $selectedItemIds = [];

    public $cliente_id = null;
    public $oti_item_numero = null;
    public $oti_orden_numero = null;

    public function getItemsProperty()
    {
        $query = ItemOrdenTrabajo::where('Estado', 'PENDIENTE')
            ->whereHas('ordenTrabajo', function ($q) {
                $q->whereIn('Estado', ['PENDIENTE', 'COMPLETO']);
            });

        if ($this->cliente_id) {
            $query->whereHas('ordenTrabajo', function ($q) {
                $q->where('IdCliente', $this->cliente_id);
            });
        }

        if (!empty($this->oti_item_numero)) {
            $query->where('ItemNumero', 'like', '%' . $this->oti_item_numero . '%');
        }

        if (!empty($this->oti_orden_numero)) {
            $query->whereHas('ordenTrabajo', function ($q) {
                $q->where('Numero', 'like', '%' . $this->oti_orden_numero . '%');
            });
        }

        if (!empty($this->selectedItemIds)) {
            $selectedItems = ItemOrdenTrabajo::whereIn('id', $this->selectedItemIds)
                ->where('Estado', 'PENDIENTE')
                ->whereHas('ordenTrabajo', function ($q) {
                    $q->whereIn('Estado', ['PENDIENTE', 'COMPLETO']);
                })
                ->get();

            $filteredItems = $query->whereNotIn('id', $this->selectedItemIds)->get();

            return $selectedItems->concat($filteredItems);
        }

        return $query->get();
    }

    public function render()
    {
        return view('livewire.valorizar-trabajos', [
            'clientes' => Client::all(),
            'items' => $this->items,
        ]);
    }
}
