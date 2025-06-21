<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use Illuminate\Support\Carbon;
use App\Models\Client;

class FiltrarItemsOrdenTrabajoPesoResumido extends Component
{
    public $fecha_inicio;
    public $fecha_fin;

    public $cc_min;
    public $cc_max;

    public $tratamientos_seleccionados = [];
    public $cliente_id = null;

    public function render()
    {
        $query = ItemOrdenTrabajo::with([
            'ordenTrabajo.cliente',
            'tratamiento',
            'material',
            'dureza',
            'programacion.tipoProgramacion',
            'programacion.medioEnfriamiento',
        ]);

        if ($this->fecha_inicio && $this->fecha_fin) {
            $query->whereBetween('FechaCreacion', [
                Carbon::parse($this->fecha_inicio)->startOfDay(),
                Carbon::parse($this->fecha_fin)->endOfDay(),
            ]);
        }

        if ($this->cc_min !== null) {
            $query->where('CodigoComplejidad', '>=', $this->cc_min);
        }

        if ($this->cc_max !== null) {
            $query->where('CodigoComplejidad', '<=', $this->cc_max);
        }

        if (!empty($this->tratamientos_seleccionados)) {
            $query->whereIn('IdTratamiento', $this->tratamientos_seleccionados);
        }

        if ($this->cliente_id) {
            $query->whereHas('ordenTrabajo', fn($q) => $q->where('IdCliente', $this->cliente_id));
        }

        return view('livewire.filtrar-items-orden-trabajo-peso-resumido', [
            'items_orden_trabajo' => $query->get(),
            'tratamientos' => Tratamiento::all(),
            'clientes' => Client::all(),
        ]);
    }
}
