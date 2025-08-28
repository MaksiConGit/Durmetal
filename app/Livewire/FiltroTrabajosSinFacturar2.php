<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use Livewire\Component;

class FiltroTrabajosSinFacturar2 extends Component
{
    public $cliente_desde = '';
    public $cliente_hasta = '';
public $expanded = [];

    public $items_orden_trabajo = [];

    public function mount()
    {
        // Inicialmente vacío o puedes cargar todos
        $this->items_orden_trabajo = [];
    }

    public function toggleExpand($id)
{
    if (in_array($id, $this->expanded)) {
        $this->expanded = array_diff($this->expanded, [$id]);
    } else {
        $this->expanded[] = $id;
    }
}


    public function buscar()
    {
        $this->items_orden_trabajo = ItemOrdenTrabajo::with(['ordenTrabajo.cliente', 'tratamiento', 'material', 'dureza', 'programacion'])
            ->whereHas('ordenTrabajo.cliente', function ($query) {
                if ($this->cliente_desde) {
                    $query->whereRaw('LEFT(Nombre, 1) >= ?', [strtoupper($this->cliente_desde)]);
                }
                if ($this->cliente_hasta) {
                    $query->whereRaw('LEFT(Nombre, 1) <= ?', [strtoupper($this->cliente_hasta)]);
                }
            })
            ->get();
    }

public function render()
{
    return view('livewire.filtro-trabajos-sin-facturar2', [
        'items_orden_trabajo' => $this->items_orden_trabajo,
        'expanded' => $this->expanded, // <--- esto hace que Blade lo reconozca
    ]);
}

}
