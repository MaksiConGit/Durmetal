<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use Illuminate\Support\Carbon;
use App\Models\Client;

class FiltrarItemsOrdenTrabajoPremiosPorAprobacion extends Component
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
            $query->whereBetween('FechaActualizacionEstado', [
                Carbon::parse($this->fecha_inicio)->startOfDay(),
                Carbon::parse($this->fecha_fin)->endOfDay(),
            ]);
        }

        $query->where('Estado', 'APROBADO');

        return view('livewire.filtrar-items-orden-trabajo-premios-por-aprobacion', [
            'items_orden_trabajo' => $query->get(),
        ]);
    }

}
