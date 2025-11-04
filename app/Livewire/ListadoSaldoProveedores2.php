<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Facturacompra;
use App\Models\FacturaVenta;
use App\Models\MinutaCompra;
use App\Models\NotaCreditoCompra;
use App\Models\NotaEnvio;
use App\Models\ReciboVenta;
use App\Models\NotaCreditoVenta;
use App\Models\Ordenpago;
use App\Models\Proveedor;
use Carbon\Carbon;
use Livewire\Component;

class ListadoSaldoProveedores2 extends Component
{
    public $lista_desde = '';
    public $lista_hasta = '';
    public $hasta_fecha = null;
    public $incluir_saldos = false;
    public $clienteSeleccionado = null;
    
    public function mount()
    {
        $this->hasta_fecha = Carbon::today()->format('Y-m-d');
    }

    public function seleccionarCliente($clienteId)
    {
        $this->clienteSeleccionado = $clienteId;
    }

    public function render()
    {
        $query = Proveedor::query();

        if (!empty($this->lista_desde)) {
            $query->where('Nombre', '>=', $this->lista_desde);
        }
        if (!empty($this->lista_hasta)) {
            $query->where('Nombre', '<=', $this->lista_hasta . 'z');
        }

        $proveedores = $query->get();

        foreach ($proveedores as $proveedor) {
            $factura_total = Facturacompra::where('IdProveedor', $proveedor->id)
                ->whereDate('FechaEmision', '<=', $this->hasta_fecha)
                ->sum('Total');

            $nota_credito_total = NotaCreditoCompra::where('IdProveedor', $proveedor->id)
                ->whereDate('FechaEmision', '<=', $this->hasta_fecha)
                ->sum('Total');

            $orden_pago_total = Ordenpago::where('IdProveedor', $proveedor->id)
                ->whereDate('FechaEmision', '<=', $this->hasta_fecha)
                ->sum('Total');

            $minutas = MinutaCompra::where('IdProveedor', $proveedor->id)
                ->whereDate('FechaEmision', '<=', $this->hasta_fecha)
                ->get();

            $minuta_total = 0;
            foreach ($minutas as $minuta) {
                if ($minuta->TipoOperacion === 'DEBITO') {
                    $minuta_total += $minuta->Total;
                } else {
                    $minuta_total -= $minuta->Total;
                }
            }

            $proveedor->saldo = $proveedor->SaldoSistemaAnterior
                + $factura_total
                - $nota_credito_total
                - $orden_pago_total
                + $minuta_total;

            $factura_mas_atrasada = FacturaCompra::where('IdProveedor', $proveedor->id)
                ->where('Estado', 'PENDIENTE')
                ->whereDate('FechaEmision', '<=', $this->hasta_fecha)
                ->orderBy('FechaVencimiento', 'asc')
                ->select('FechaEmision', 'FechaVencimiento')
                ->first();

            $proveedor->factura_atrasada_emision = $factura_mas_atrasada->FechaEmision ?? null;
            $proveedor->factura_atrasada_vencimiento = $factura_mas_atrasada->FechaVencimiento ?? null;
        }

        if (!$this->incluir_saldos) {
            $proveedores = $proveedores->filter(fn($p) => $p->saldo != 0)->values();
        }

        return view('livewire.listado-saldo-proveedores2', compact('proveedores'));

    }

}
