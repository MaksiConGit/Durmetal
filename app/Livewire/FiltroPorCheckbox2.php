<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use App\Models\Client;
use Livewire\Component;

class FiltroPorCheckbox2 extends Component
{
    public $selectedIds = [];
    public $selectedItemIds = [];

    public $cliente_id = null;
    public $oti_item_numero = null;
    public $oti_orden_numero = null;
    public $expanded = [];
    public $search = '';
    public $cliente_nombre = null;

    public function toggleExpand($id)
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            $this->expanded[] = $id;
        }
    }

    public function cancelarCliente()
    {
        $this->cliente_id = null;
        $this->cliente_nombre = null;
    }

    public function updatedClienteId($value)
    {
        $cliente = Client::find($value);

        if ($cliente) {
            $this->cliente_nombre = $cliente->Nombre;
        } else {
            $this->cliente_nombre = null;
        }
    }

    public function seleccionarCliente($id)
    {
        $cliente = Client::find($id);

        if ($cliente) {
            $this->cliente_id = $cliente->id;
            $this->cliente_nombre = $cliente->Nombre;
        }
    }

    public function getItemsProperty()
    {
        $query = ItemOrdenTrabajo::where('Estado', 'PENDIENTE')
            ->whereHas('ordenTrabajo', function ($q) {
                $q->whereIn('Estado', ['PENDIENTE', 'COMPLETO']);
            });

        if (!empty($this->selectedIds)) {
            $query->whereIn('IdTratamiento', $this->selectedIds);
        }

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
            return ItemOrdenTrabajo::where('Estado', 'PENDIENTE')
                ->whereHas('ordenTrabajo', function ($q) {
                    $q->whereIn('Estado', ['PENDIENTE', 'COMPLETO']);
                })
                ->when(!empty($this->selectedIds), function ($q) {
                    $q->whereIn('IdTratamiento', $this->selectedIds);
                })
                ->when($this->cliente_id, function ($q) {
                    $q->whereHas('ordenTrabajo', fn($q) => $q->where('IdCliente', $this->cliente_id));
                })
                ->when(!empty($this->oti_item_numero), function ($q) {
                    $q->where('ItemNumero', 'like', '%' . $this->oti_item_numero . '%');
                })
                ->when(!empty($this->oti_orden_numero), function ($q) {
                    $q->whereHas('ordenTrabajo', fn($q) => $q->where('Numero', 'like', '%' . $this->oti_orden_numero . '%'));
                })
                ->orderBy('id')
                ->get();
        }

        return $query->get();
    }


    public function render()
    {
        $tratamientos = Tratamiento::query();

        if (!empty($this->search)) {
            $tratamientos->where('Nombre', 'like', '%' . $this->search . '%');
        }

        return view('livewire.filtro-por-checkbox2', [
        'tratamientos' => $tratamientos->get(),
            'clientes' => Client::all(),
            'items' => $this->items,
            'expanded' => $this->expanded,
        ]);
    }
}
