<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use App\Models\Client;
use Livewire\Component;

class ValorizarTrabajos2 extends Component
{
    public $selectedItemIds = [];

    public $oti_item_numero;
    public $oti_orden_numero;

    public $cliente_id = null;
    public $cliente_nombre = null;

    public $codigoComplejidad = [];

    public $keepShowing = [];

    public $expanded = [];

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

    public function mount()
    {
        foreach ($this->items as $item) {
            $this->codigoComplejidad[$item->id] = $item->CodigoComplejidad;
        }
    }

    public function getItemsProperty()
    {
        $query = ItemOrdenTrabajo::where(function ($q) {
                $q->where('CodigoComplejidad', 0)
                  ->orWhereIn('id', $this->keepShowing);
            })
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
                ->where(function ($q) {
                    $q->where('CodigoComplejidad', 0)
                      ->orWhereIn('id', $this->keepShowing);
                })
                ->whereHas('ordenTrabajo', function ($q) {
                    $q->whereIn('Estado', ['PENDIENTE', 'COMPLETO']);
                })
                ->get();

            $filteredItems = $query->whereNotIn('id', $this->selectedItemIds)->get();

            return $selectedItems->concat($filteredItems);
        }

        return $query->get();
    }

    public function updatedCodigoComplejidad($value, $key)
    {
        $value = $value === '' ? 0 : $value;

        ItemOrdenTrabajo::where('id', $key)->update([
            'CodigoComplejidad' => $value
        ]);

        if (!in_array($key, $this->keepShowing)) {
            $this->keepShowing[] = $key;
        }

    $this->dispatch('trabajo-actualizado');
    }

    public function render()
    {
        return view('livewire.valorizar-trabajos2', [
            'clientes' => Client::all(),
            'items' => $this->items,
            'expanded' => $this->expanded,
        ]);
    }
}
