<?php

namespace App\Livewire;

use App\Models\CuentaOtrosEgresos;
use App\Models\MovimientoCuentaGastos;
use Carbon\Carbon;
use Livewire\Component;

class OtrosEgresosCuentas2 extends Component
{
    public $selectedId = null;

    public function selectClient($id)
    {
        $this->selectedId = $id;
    }

    public function render()
    {
        $cuentas_otros_egresos = CuentaOtrosEgresos::whereNull('IdCuentaOtrosEgresosPadre')
                                    ->orderBy('Nombre', 'asc')
                                    ->with('hijos')
                                    ->get();

        return view('livewire.otros-egresos-cuentas2', [
            'cuentas_otros_egresos' => $cuentas_otros_egresos
        ]);
    }
}