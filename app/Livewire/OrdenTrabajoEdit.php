<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Dureza;
use App\Models\Material;
use App\Models\Tratamiento;
use Livewire\Component;

class OrdenTrabajoEdit extends Component
{
    public $selectedId = null;
    public $selectedIdItem = null;
    public $orden_trabajo;
    public $items_orden_trabajo;
    public $clientes;
    public $pto_ventas;
    public array $expanded = [];
    public $cliente_id = null;
    public $cliente_nombre = null;
    public array $items_orden_trabajo_edit = [];
    public $newItems = [];
    private $tempId = -1;

    public $activeTabParametros = 'custom-tabs-1';

    public function setActiveTabParametros($tabId)
    {
        $this->activeTabParametros = $tabId;
    }

    public function selectClient($id)
    {
        $this->selectedId = $id;
    }

    public function mount($orden_trabajo, $items_orden_trabajo, $pto_ventas)
    {
        $this->orden_trabajo = $orden_trabajo;
        $this->items_orden_trabajo = $items_orden_trabajo;
        $this->pto_ventas = $pto_ventas;
        $this->clientes = Client::all();
        $this->cliente_id = $orden_trabajo->IdCliente ?? '';
        $this->cliente_nombre = $orden_trabajo->cliente->Nombre ?? '';

        foreach ($this->items_orden_trabajo as $item) {
            $this->items_orden_trabajo_edit[$item->id] = [
                'tratamiento_id' => $item->IdTratamiento,
                'dureza_id' => $item->IdDureza,
                'material_id' => $item->IdMaterial,
                'Descripcion' => $item->Descripcion,
                'Cantidad' => $item->Cantidad,
                'Peso' => $item->Peso,
                'DurezaSolicitadaMinima' => $item->DurezaSolicitadaMinima,
                'DurezaSolicitadaMaxima' => $item->DurezaSolicitadaMaxima,
                'Observaciones' => $item->Observaciones,
            ];
        }

    }

    public function toggleExpand($id)
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            $this->expanded[] = $id;
        }

        $this->selectedIdItem = $id;
    }

    public function addNewItem()
    {
        $newItemId = $this->tempId;

        $this->newItems[$newItemId] = [
            'id' => $newItemId,
            'Descripcion' => '',
            'Cantidad' => 1,
            'Peso' => 0,
            'material_id' => Material::where('Predeterminado', 1)->first()->id ?? 1,
            'tratamiento_id' => Tratamiento::where('Predeterminado', 1)->first()->id ?? 1,
            'dureza_id' => Dureza::where('Predeterminado', 1)->first()->id ?? 1,
            'DurezaSolicitadaMinima' => 0,
            'DurezaSolicitadaMaxima' => 0,
        ];

        if (! in_array($newItemId, $this->expanded)) {
            $this->expanded[] = $newItemId;
        }

        $this->selectedIdItem = $newItemId;

        $this->tempId--;
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

    public function deleteItem($id)
    {
        if (isset($this->newItems[$id])) {
            unset($this->newItems[$id]);
        } else {
            $item = $this->items_orden_trabajo->find($id);
            if ($item) {
                $item->delete();
                $this->items_orden_trabajo = $this->items_orden_trabajo->except($id);
            }
        }

        $this->expanded = array_diff($this->expanded, [$id]);

        if ($this->selectedIdItem == $id) {
            $this->selectedIdItem = null;
        }
    }

    public function seleccionarTratamiento($itemId, $tratamientoId)
    {
        if (isset($this->newItems[$itemId])) {
            $this->newItems[$itemId]['tratamiento_id'] = $tratamientoId;
        }
    }

    public function seleccionarDureza($itemId, $durezaId)
    {
        if (isset($this->newItems[$itemId])) {
            $this->newItems[$itemId]['dureza_id'] = $durezaId;
        }
    }

    public function seleccionarMaterial($itemId, $materialId)
    {
        if (isset($this->newItems[$itemId])) {
            $this->newItems[$itemId]['material_id'] = $materialId;
        }
    }

    public function seleccionarTratamientoExistente($itemId, $tratamientoId)
    {
        if(isset($this->items_orden_trabajo_edit[$itemId])) {
            $this->items_orden_trabajo_edit[$itemId]['tratamiento_id'] = $tratamientoId;
        }
    }

    public function seleccionarDurezaExistente($itemId, $durezaId)
    {
        if(isset($this->items_orden_trabajo_edit[$itemId])) {
            $this->items_orden_trabajo_edit[$itemId]['dureza_id'] = $durezaId;
        }
    }

    public function seleccionarMaterialExistente($itemId, $materialId)
    {
        if(isset($this->items_orden_trabajo_edit[$itemId])) {
            $this->items_orden_trabajo_edit[$itemId]['material_id'] = $materialId;
        }
    }

    public function render()
    {
        return view('livewire.orden-trabajo-edit', [
            'expanded' => $this->expanded,
            'tratamientos' => Tratamiento::all(),
            'durezas' => Dureza::all(),
            'materiales' => Material::all(),
        ]);
    }
}
