<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use App\Models\Client;
use Illuminate\Support\Carbon;

class FiltrarItemsOrdenTrabajoIngresoDatos2 extends Component
{
    public $fecha_inicio;
    public $fecha_fin;

    public $oti_item_numero;
    public $oti_orden_numero;

    public $cliente_id = null;
    public array $expanded = [];
    public array $expandedInner = [];
    public $cliente_nombre = null;


    public function mount()
    {
        $this->fecha_fin = now()->format('Y-m-d');
        $this->fecha_inicio = now()->subMonth()->format('Y-m-d');
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

    public function toggleExpand($id)
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            $this->expanded[] = $id;
        }
    }

    public function toggleExpandInner($id)
    {
        if (in_array($id, $this->expandedInner)) {
            $this->expandedInner = array_diff($this->expandedInner, [$id]);
        } else {
            $this->expandedInner[] = $id;
        }
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

        return view('livewire.filtrar-items-orden-trabajo-ingreso-datos2', [
            'items_orden_trabajo' => $query->get(),
            'tratamientos' => Tratamiento::all(),
            'clientes' => Client::all(),
            'expanded' => $this->expanded,
        ]);
    }
}
