<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use App\Models\Material;
use Illuminate\Support\Carbon;
use App\Models\Client;

class FiltrarItemsOrdenTrabajoMaterialResumido extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $dureza_min;
    public $dureza_max;
    public $materiales_seleccionados = [];
    public $cliente_id = null;

    public function mount()
    {
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
        $this->fecha_inicio = Carbon::now()->subMonths(3)->format('Y-m-d');
    }

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

        if ($this->dureza_min) {
            $query->where('DurezaSolicitadaMinima', '>=', $this->dureza_min);
        }

        if ($this->dureza_max) {
            $query->where('DurezaSolicitadaMaxima', '<=', $this->dureza_max);
        }

        if (!empty($this->materiales_seleccionados)) {
            $query->whereIn('IdMaterial', $this->materiales_seleccionados);
        }

        if ($this->cliente_id) {
            $query->whereHas('ordenTrabajo', fn($q) => $q->where('IdCliente', $this->cliente_id));
        }

        return view('livewire.filtrar-items-orden-trabajo-material-resumido', [
            'items_orden_trabajo' => $query->get(),
            'materiales' => Material::all(),
            'clientes' => Client::all(),
        ]);
    }
}