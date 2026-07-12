<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use App\Models\Material;
use Carbon\Carbon;
use App\Models\Client;
use Livewire\Component;
use App\Exports\ReportesMaterialesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportesMaterialesResumido extends Component
{
    public $selectedIds = [];
    public $selectedItemIds = [];

    public $cliente_id = null;
    public $oti_item_numero = null;
    public $oti_orden_numero = null;
    public $expanded = [];
    public $search = '';
    public $cliente_nombre = null;
    public $fecha_inicio;
    public $fecha_fin;
    public $dureza_min;
    public $dureza_max;
    public $materiales_seleccionados = [];


    public function mount()
    {
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
        $this->fecha_inicio = Carbon::now()->subMonths(3)->format('Y-m-d');
    }

    private function getItemsFiltrados()
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

        if ($this->dureza_min !== null && $this->dureza_min !== '') {
            $query->where('DurezaSolicitadaMaxima', '>=', $this->dureza_min);
        }

        if ($this->dureza_max !== null && $this->dureza_max !== '') {
            $query->where('DurezaSolicitadaMinima', '<=', $this->dureza_max);
        }

        if (!empty($this->materiales_seleccionados)) {
            $query->whereIn('IdMaterial', $this->materiales_seleccionados);
        }

        if ($this->cliente_id) {
            $query->whereHas('ordenTrabajo', function ($q) {
                $q->where('IdCliente', $this->cliente_id);
            });
        }

        if (!empty($this->oti_item_numero)) {
            $query->where('ItemNumero', 'like', '%' . $this->oti_item_numero . '%');
        }

        if (!empty($this->oti_orden_numero)) {
            $query->whereHas('ordenTrabajo', function ($q) {
                $q->where('Numero', 'like', '%' . $this->oti_orden_numero . '%');
            });
        }

        return $query;
    }

    public function exportarExcel()
    {
        return Excel::download(
            new ReportesMaterialesExport(
                $this->getItemsFiltrados()->get()
            ),
            'reporte-materiales-resumido.xlsx'
        );
    }

    public function render()
    {
        $query = $this->getItemsFiltrados();

        $materiales = Material::query();

        if (!empty($this->search)) {
            $materiales->where('Nombre', 'like', '%' . $this->search . '%');
        }

        if ($this->fecha_inicio && $this->fecha_fin) {
            $query->whereBetween('FechaCreacion', [
                Carbon::parse($this->fecha_inicio)->startOfDay(),
                Carbon::parse($this->fecha_fin)->endOfDay(),
            ]);
        }

        if ($this->dureza_min !== null && $this->dureza_min !== '') {
            $query->where('DurezaSolicitadaMaxima', '>=', $this->dureza_min);
        }

        if ($this->dureza_max !== null && $this->dureza_max !== '') {
            $query->where('DurezaSolicitadaMinima', '<=', $this->dureza_max);
        }

        if (!empty($this->materiales_seleccionados)) {
            $query->whereIn('IdMaterial', $this->materiales_seleccionados);
        }

        if ($this->cliente_id) {
            $query->whereHas('ordenTrabajo', fn($q) =>
                $q->where('IdCliente', $this->cliente_id)
            );
        }

        if (!empty($this->oti_item_numero)) {
            $query->where('ItemNumero', 'like', '%' . $this->oti_item_numero . '%');
        }

        if (!empty($this->oti_orden_numero)) {
            $query->whereHas('ordenTrabajo', fn($q) =>
                $q->where('Numero', 'like', '%' . $this->oti_orden_numero . '%')
            );
        }

        return view('livewire.reportes-materiales-resumido', [
            'items_orden_trabajo' => $query->get(),
            'materiales' => $materiales->get(),
            'clientes' => Client::all(),
        ]);
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

    public function getItemsProperty()
    {
        $query = ItemOrdenTrabajo::where('Estado', 'PENDIENTE')
            ->whereHas('ordenTrabajo', function ($q) {
                $q->whereIn('Estado', ['PENDIENTE', 'COMPLETO']);
            });

        if (!empty($this->selectedIds)) {
            $query->whereIn('IdTratamiento', $this->selectedIds);
        }

        if ($this->cliente_id) {
            $query->whereHas('ordenTrabajo', function ($q) {
                $q->where('IdCliente', $this->cliente_id);
            });
        }

        if (!empty($this->oti_item_numero)) {
            $query->where('ItemNumero', 'like', '%' . $this->oti_item_numero . '%');
        }

        if (!empty($this->oti_orden_numero)) {
            $query->whereHas('ordenTrabajo', function ($q) {
                $q->where('Numero', 'like', '%' . $this->oti_orden_numero . '%');
            });
        }

        if (!empty($this->selectedItemIds)) {
            return ItemOrdenTrabajo::where('Estado', 'PENDIENTE')
                ->whereHas('ordenTrabajo', function ($q) {
                    $q->whereIn('Estado', ['PENDIENTE', 'COMPLETO']);
                })
                ->when(!empty($this->selectedIds), function ($q) {
                    $q->whereIn('IdTratamiento', $this->selectedIds);
                })
                ->when($this->cliente_id, function ($q) {
                    $q->whereHas('ordenTrabajo', fn($q) => $q->where('IdCliente', $this->cliente_id));
                })
                ->when(!empty($this->oti_item_numero), function ($q) {
                    $q->where('ItemNumero', 'like', '%' . $this->oti_item_numero . '%');
                })
                ->when(!empty($this->oti_orden_numero), function ($q) {
                    $q->whereHas('ordenTrabajo', fn($q) => $q->where('Numero', 'like', '%' . $this->oti_orden_numero . '%'));
                })
                ->orderBy('id')
                ->get()
                ->sortBy(function ($item) {
                    return $item->programacion->unique('NumeroProgramacion')->count();
                })
                ->values();
        }

        return $query->get()
            ->sortBy(function ($item) {
                return $item->programacion->unique('NumeroProgramacion')->count();
            })
            ->values();
    }

    // public function render()
    // {
    //     $materiales = Material::query();

    //     if (!empty($this->search)) {
    //         $materiales->where('Nombre', 'like', '%' . $this->search . '%');
    //     }

    //     return view('livewire.reportes-materiales', [
    //         'materiales' => $materiales->get(),
    //         'clientes' => Client::all(),
    //         'items' => $this->items,
    //         'expanded' => $this->expanded,
    //     ]);
    // }
}
