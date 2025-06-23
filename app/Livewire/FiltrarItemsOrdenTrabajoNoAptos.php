<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use App\Models\Client;
use Illuminate\Support\Carbon;

class FiltrarItemsOrdenTrabajoNoAptos extends Component
{
    public $fecha_inicio;
    public $fecha_fin;

    public $oti_item_numero;
    public $oti_orden_numero;

    public $tratamientos_seleccionados = [];
    public $cliente_id = null;

    public function render()
    {
        $query = ItemOrdenTrabajo::with([
            'ordenTrabajo.cliente',
            'tratamiento',
            'material',
            'programacion.tipoProgramacion',
            'programacion.medioEnfriamiento',
        ])
        ->whereHas('programacion', function ($q) {
            $q->where('Apto', '<>', 'SI');
        });

        if ($this->fecha_inicio && $this->fecha_fin) {
            $query->whereBetween('FechaCreacion', [
                Carbon::parse($this->fecha_inicio)->startOfDay(),
                Carbon::parse($this->fecha_fin)->endOfDay(),
            ]);
        }

        if (!empty($this->oti_item_numero)) {
            $query->where('ItemNumero', 'like', '%' . $this->oti_item_numero . '%');
        }

        if (!empty($this->oti_orden_numero)) {
            $query->whereHas('ordenTrabajo', function ($q) {
                $q->where('Numero', 'like', '%' . $this->oti_orden_numero . '%');
            });
        }

        if (!empty($this->tratamientos_seleccionados)) {
            $query->whereIn('IdTratamiento', $this->tratamientos_seleccionados);
        }

        if ($this->cliente_id) {
            $query->whereHas('ordenTrabajo', fn($q) => $q->where('IdCliente', $this->cliente_id));
        }

        return view('livewire.filtrar-items-orden-trabajo-no-aptos', [
            'items_orden_trabajo' => $query->get(),
            'tratamientos' => Tratamiento::all(),
            'clientes' => Client::all(),
        ]);
    }
}
