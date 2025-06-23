<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use Illuminate\Support\Carbon;

class FiltrarItemsOrdenTrabajoPremios extends Component
{
    public $fecha_inicio;
    public $fecha_fin;

    public function render()
    {
        $query = ItemOrdenTrabajo::with([
            'ordenTrabajo.cliente',
            'tratamiento',
            'material',
            'codigoComplejidad',
        ]);

        if ($this->fecha_inicio && $this->fecha_fin) {
            $query->whereHas('ordenTrabajo', function ($q) {
                $q->whereBetween('FechaEmision', [
                    Carbon::parse($this->fecha_inicio)->startOfDay(),
                    Carbon::parse($this->fecha_fin)->endOfDay(),
                ]);
            });
        }

        $query->where('Estado', 'APROBADO');

        return view('livewire.filtrar-items-orden-trabajo-premios', [
            'items_orden_trabajo' => $query->get(),
        ]);
    }
}
