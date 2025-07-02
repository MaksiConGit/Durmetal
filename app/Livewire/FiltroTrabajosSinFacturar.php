<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use Livewire\Component;

class FiltroTrabajosSinFacturar extends Component
{
    public $cliente_desde = '';
    public $cliente_hasta = '';

    public function render()
    {
        $items_orden_trabajo = ItemOrdenTrabajo::with(['ordenTrabajo.cliente', 'tratamiento', 'material', 'dureza', 'programacion'])
            ->whereHas('ordenTrabajo.cliente', function ($query) {
                if ($this->cliente_desde) {
                    $query->whereRaw('LEFT(Nombre, 1) >= ?', [strtoupper($this->cliente_desde)]);
                }
                if ($this->cliente_hasta) {
                    $query->whereRaw('LEFT(Nombre, 1) <= ?', [strtoupper($this->cliente_hasta)]);
                }
            })
            ->get();

        return view('livewire.filtro-trabajos-sin-facturar', [
            'items_orden_trabajo' => $items_orden_trabajo,
        ]);
    }
}