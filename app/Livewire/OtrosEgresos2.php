<?php

namespace App\Livewire;

use App\Models\MovimientoCuentaGastos;
use Carbon\Carbon;
use Livewire\Component;

class OtrosEgresos2 extends Component
{
    public $cliente_desde;
    public $cliente_hasta;
    public $selectedId = null;

    public function selectClient($id)
    {
        $this->selectedId = $id;
    }

    public function mount()
    {
        $this->cliente_hasta = Carbon::today()->format('Y-m-d');
        $this->cliente_desde = Carbon::today()->subMonth()->format('Y-m-d');
    }


    public function render()
    {
        $query = MovimientoCuentaGastos::query()->with('cuenta');

        if ($this->cliente_desde) {
            $query->whereDate('Fecha', '>=', $this->cliente_desde);
        }

        if ($this->cliente_hasta) {
            $query->whereDate('Fecha', '<=', $this->cliente_hasta);
        }

        $movimientos_cuenta_gastos = $query->orderBy('Fecha', 'desc')->get();

        return view('livewire.otros-egresos2', [
            'movimientos_cuenta_gastos' => $movimientos_cuenta_gastos
        ]);
    }
}