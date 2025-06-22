<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use App\Models\Client;
use Illuminate\Support\Carbon;

class FiltrarItemsOrdenTrabajoIngresoDatos extends Component
{
    public $fecha_inicio;
    public $fecha_fin;

    public $oti_item_numero;
    public $oti_orden_numero;

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
            'programacion.ejecutadoPorOperador'
        ])
        ->whereIn('Estado', ['PENDIENTE', 'APROBADO'])
        ->whereHas('programacion');

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

        if ($this->cliente_id) {
            $query->whereHas('ordenTrabajo', fn($q) => $q->where('IdCliente', $this->cliente_id));
        }

        return view('livewire.filtrar-items-orden-trabajo-ingreso-datos', [
            'items_orden_trabajo' => $query->get(),
            'tratamientos' => Tratamiento::all(),
            'clientes' => Client::all(),
        ]);
    }
}
