<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CuentaGastos;
use App\Models\CuentaOtrosEgresos;
use Carbon\Carbon;

class ResumenMensualEgresos extends Component
{
    public $cliente_desde;
    public $cliente_hasta;

    public $cuentas_gastos = [];
    public $cuentas_otros_egresos = [];

    public function mount()
    {
        $this->cliente_desde = Carbon::now()->startOfYear()->format('Y-m-d');
        $this->cliente_hasta = Carbon::now()->endOfYear()->format('Y-m-d');

        $this->actualizarDatos();
    }

    public function updated($field)
    {
        if (in_array($field, ['cliente_desde', 'cliente_hasta'])) {
            $this->actualizarDatos();
        }
    }

    public function actualizarDatos()
    {
        // === GASTOS ===
        $this->cuentas_gastos = CuentaGastos::with('proveedores.facturasCompra')
            ->get()
            ->map(function ($cuenta) {
                $mensuales = [];

                for ($i = 1; $i <= 12; $i++) {
                    $totalMes = 0;

                    foreach ($cuenta->proveedores as $proveedor) {
                        $totalMes += $proveedor->facturasCompra()
                            ->whereMonth('FechaEmision', $i)
                            ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
                            ->sum('Total');
                    }

                    $mensuales[$i] = $totalMes;
                }

                return [
                    'nombre' => $cuenta->Nombre,
                    'mensuales' => $mensuales,
                    'total' => array_sum($mensuales)
                ];
            });


        // === OTROS EGRESOS ===
        $this->cuentas_otros_egresos = CuentaOtrosEgresos::with('movimientos')
            ->get()
            ->map(function ($cuenta) {
                $mensuales = [];
                for ($i = 1; $i <= 12; $i++) {
                    $mensuales[$i] = $cuenta->movimientos()
                        ->whereMonth('Fecha', $i)
                        ->whereBetween('Fecha', [$this->cliente_desde, $this->cliente_hasta])
                        ->sum('Importe');
                }

                return [
                    'nombre' => $cuenta->Nombre,
                    'mensuales' => $mensuales,
                    'total' => array_sum($mensuales),
                ];
            });
    }

    public function render()
    {
        return view('livewire.resumen-mensual-egresos', [
            'cuentas_gastos' => $this->cuentas_gastos,
            'cuentas_otros_egresos' => $this->cuentas_otros_egresos
        ]);
    }
}
