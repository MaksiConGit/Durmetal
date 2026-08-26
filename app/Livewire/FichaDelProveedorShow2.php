<?php

namespace App\Livewire;

use App\Models\Facturacompra;
use App\Models\Proveedor;
use Livewire\Component;

class FichaDelProveedorShow2 extends Component
{
    public $activeTabParametros = 'custom-tabs-1';
    public $saldo = 0;
    public $proveedor;
    public $selectedId = 1;
    public $expanded = [];
    public $factura_venta_id = null;
    public $factura_venta = null;
    public $pendientes = 0;
    public $notaEnvio;

    // Órdenes de trabajo
    public $ot_desde, $ot_hasta;

    // Notas de envío
    public $ne_desde, $ne_hasta;

    // Facturas
    public $fact_desde, $fact_hasta;

    // Recibos
    public $rec_desde, $rec_hasta;

    // Notas de crédito
    public $nc_desde, $nc_hasta;

    // Notas de débito
    public $nd_desde, $nd_hasta;

    // Minutas
    public $min_desde, $min_hasta;


    public function mount(Proveedor $proveedor)
    {
        $desde = now()->subMonths(3)->toDateString();
        $hasta = now()->toDateString();

        $this->ot_desde = $desde;
        $this->ot_hasta = $hasta;

        $this->ne_desde = $desde;
        $this->ne_hasta = $hasta;

        $this->fact_desde = $desde;
        $this->fact_hasta = $hasta;

        $this->rec_desde = $desde;
        $this->rec_hasta = $hasta;

        $this->nc_desde = $desde;
        $this->nc_hasta = $hasta;

        $this->nd_desde = $desde;
        $this->nd_hasta = $hasta;

        $this->min_desde = $desde;
        $this->min_hasta = $hasta;

        $this->proveedor = $proveedor;
        // $this->factura_venta_id = 1;
        // $this->notaEnvio = NotaEnvio::find($this->selectedId);

        $this->calcularSaldo();
    }

    public function cancelarCliente()
    {
        $this->factura_venta_id = null;
    }

    public function updatedClienteId($value)
    {
        $factura_venta = FacturaVenta::find($value);
    }

    public function seleccionarCliente($id)
    {
        $factura_venta = FacturaVenta::find($id);

        if ($factura_venta) {
            $this->factura_venta_id = $factura_venta->id;
        }
    }

    public function toggleExpand($id)
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            $this->expanded[] = $id;
        }
        
        $this->selectedId = $id;
        $this->notaEnvio = NotaEnvio::find($this->selectedId);
    }

    public function setActiveTabParametros($tabId)
    {
        $this->activeTabParametros = $tabId;

        $this->expanded = [];
    }

    private function calcularSaldo()
    {
        if (!$this->proveedor) {
            $this->saldo = 0;
            return;
        }

        $id = $this->proveedor->id;

        $totalFacturas = $this->proveedor->facturasCompra()->sum('Total');
        $totalDebitos  = $this->proveedor->notasDebitoCompra()->sum('Total');
        $totalCreditos = $this->proveedor->notasCreditoCompra()->sum('Total');
        $totalOrdenesPago = $this->proveedor->ordenesPago()->sum('Total');

        $this->saldo = $this->proveedor->Saldo
            + $totalFacturas
            + $totalDebitos
            - $totalCreditos
            - $totalOrdenesPago;
    }

    private function filtrar($query, $desde, $hasta)
    {
        return $query->whereBetween('FechaEmision', [$desde, $hasta]);
    }

    public function render()
    {
        $facturas = $this->filtrar(
            $this->proveedor->facturasCompra(),
            $this->fact_desde,
            $this->fact_hasta
        )->orderBy('FechaEmision', 'desc')->get();

        $notas_de_debito = $this->filtrar(
            $this->proveedor->notasDebitoCompra(),
            $this->nd_desde,
            $this->nd_hasta
        )->orderBy('FechaEmision', 'desc')->get();

        $notas_de_credito = $this->filtrar(
            $this->proveedor->notasCreditoCompra(),
            $this->nc_desde,
            $this->nc_hasta
        )->orderBy('FechaEmision', 'desc')->get();

        $ordenes_pago = $this->filtrar(
            $this->proveedor->ordenesPago(),
            $this->ne_desde,
            $this->ne_hasta
        )->orderBy('FechaEmision', 'desc')->get();

        $orden_pago_pendiente_mas_antiguo = $ordenes_pago->where('Estado', 'PENDIENTE')
            ->sortBy('FechaEmision')
            ->first();

        $minutas = $this->filtrar(
            $this->proveedor->minutasCompra(),
            $this->min_desde,
            $this->min_hasta
        )->orderBy('FechaEmision', 'desc')->get();

        $facturas_pendientes = $this->filtrar(
            Facturacompra::where('IdProveedor', $this->proveedor->id)
                ->where('Estado', 'PENDIENTE'),
            $this->fact_desde,
            $this->fact_hasta
        )->orderBy('FechaEmision', 'desc')->get();

        $facturas_pendientes_completas = $this->filtrar(
            Facturacompra::where('IdProveedor', $this->proveedor->id),
            $this->fact_desde,
            $this->fact_hasta
        )->orderBy('FechaEmision', 'desc')->get();

        return view('livewire.ficha-del-proveedor-show2', [
            'ordenes_pago'  => $ordenes_pago,
            'facturas'         => $facturas,
            'orden_pago_pendiente_mas_antiguo' => $orden_pago_pendiente_mas_antiguo,
            'notas_de_credito' => $notas_de_credito,
            'notas_de_debito'  => $notas_de_debito,
            'minutas'          => $minutas,
            'facturas_pendientes' => $facturas_pendientes,
            'facturas_pendientes_completas' => $facturas_pendientes_completas,
            'saldo' => $this->saldo,
        ]);
    }

}
