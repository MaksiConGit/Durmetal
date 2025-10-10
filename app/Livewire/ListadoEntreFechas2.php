<?php

namespace App\Livewire;

use App\Models\CuentaOtrosEgresos;
use Carbon\Carbon;
use Livewire\Component;


class ListadoEntreFechas2 extends Component
{
    public $cliente_desde;
    public $cliente_hasta;

    public $cuentas_otros_egresos;
    public $total_general;

    public function mount()
    {
        $this->cliente_hasta = Carbon::today()->format('Y-m-d');
        $this->cliente_desde = Carbon::today()->subMonth(3)->format('Y-m-d');
    }

    public function render()
    {
        $this->cuentas_otros_egresos = CuentaOtrosEgresos::whereNull('IdCuentaOtrosEgresosPadre')
            ->orderBy('Nombre', 'asc')
            ->with(['hijos.movimientos', 'movimientos'])
            ->get();

        $this->total_general = 0;

        foreach ($this->cuentas_otros_egresos as $padre) {
            $padre->total_movimientos = $padre->movimientos
                ->where('Fecha', '>=', $this->cliente_desde)
                ->where('Fecha', '<=', $this->cliente_hasta)
                ->sum('Importe');

            foreach ($padre->hijos as $hijo) {
                $hijo->total_movimientos = $hijo->movimientos
                    ->where('Fecha', '>=', $this->cliente_desde)
                    ->where('Fecha', '<=', $this->cliente_hasta)
                    ->sum('Importe');

                $padre->total_movimientos += $hijo->total_movimientos;
            }

            $this->total_general += $padre->total_movimientos;
        }

        return view('livewire.listado-entre-fechas2');
    }
}