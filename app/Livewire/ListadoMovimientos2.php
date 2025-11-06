<?php

namespace App\Livewire;

use App\Models\CuentaGastos;
use App\Models\Proveedor;
use Carbon\Carbon;
use Livewire\Component;

class ListadoMovimientos2 extends Component
{
    public $fechaDesde;
    public $fechaHasta;
    public $filtro;
    public $cuentas_de_gastos;

    public function mount()
    {
        $this->fechaHasta = Carbon::today()->format('Y-m-d');
        $this->fechaDesde = Carbon::today()->subMonth()->format('Y-m-d');

        $this->cuentas_de_gastos = CuentaGastos::all();
    }

    public function getFacturasFiltradasProperty()
    {
        return \App\Models\FacturaCompra::query()
            ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
            ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
            ->orderBy('FechaEmision', 'desc')
        ->when($this->filtro, function ($q) {
            $q->whereHas('items.cuentaGastos', function ($q2) {
                $q2->where('id', $this->filtro);
            });
        })
        ->with(['items.cuentaGastos', 'proveedor'])
        ->orderBy('FechaEmision', 'desc')
        ->get();
    }

    public function getNotasCreditoFiltradasProperty()
    {
        return \App\Models\NotaCreditoCompra::query()
            ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
            ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
            ->orderBy('FechaEmision', 'desc')
        ->when($this->filtro, function ($q) {
            $q->whereHas('items.cuentaGastos', function ($q2) {
                $q2->where('id', $this->filtro);
            });
        })
        ->with(['items.cuentaGastos', 'proveedor'])
        ->orderBy('FechaEmision', 'desc')
        ->get();
    }

    public function getUrlEditarDocumento($documento)
    {
        if ($documento instanceof \App\Models\FacturaCompra) {
            return route('compras.ficha-del-proveedor.factura-compra.create', $documento->id);
        }

        if ($documento instanceof \App\Models\NotaCreditoCompra) {
            return route('compras.ficha-del-proveedor.nota-credito.create', $documento->id);
        }

        return '#';
    }

    public function render()
    {
        return view('livewire.listado-movimientos2', [
            'proveedores' => Proveedor::all(),
        ]);
    }
}
