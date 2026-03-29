<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\FacturaVenta;
use App\Models\NotaEnvio;
use Livewire\Component;

class FichaDelClienteShow2 extends Component
{
    public $activeTabParametros = 'custom-tabs-1';
    public $saldo = 0;
    public $cliente;
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


    public function mount(Client $cliente)
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

        $this->cliente = $cliente;
        $this->factura_venta_id = 1;
        $this->notaEnvio = NotaEnvio::find($this->selectedId);

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
    }

    private function calcularSaldo()
    {
        if (!$this->cliente) {
            $this->saldo = 0;
            return;
        }

        $id = $this->cliente->id;

        $totalFacturas = $this->cliente->facturasVenta()->sum('Total');
        $totalDebitos  = $this->cliente->notasDeDebito()->sum('Total');
        $totalRecibos  = $this->cliente->recibosVenta()->sum('Total');
        $totalCreditos = $this->cliente->notasDeCredito()->sum('Total');

        $this->saldo = $this->cliente->SaldoSistemaAnterior
            + $totalFacturas
            + $totalDebitos
            - $totalRecibos
            - $totalCreditos;
    }

    private function filtrar($query, $desde, $hasta)
    {
        return $query->whereBetween('FechaEmision', [$desde, $hasta]);
    }

public function render()
{
    $ordenes_trabajo = $this->filtrar(
        $this->cliente->ordenesTrabajo(),
        $this->ot_desde,
        $this->ot_hasta
    )->orderBy('FechaEmision', 'desc')->get();

    $notas_de_envio = $this->filtrar(
        $this->cliente->notasDeEnvio(),
        $this->ne_desde,
        $this->ne_hasta
    )->orderBy('FechaEmision', 'desc')->get();

    $facturas = $this->filtrar(
        $this->cliente->facturasVenta(),
        $this->fact_desde,
        $this->fact_hasta
    )->orderBy('FechaEmision', 'desc')->get();

    $recibos = $this->filtrar(
        $this->cliente->recibosVenta(),
        $this->rec_desde,
        $this->rec_hasta
    )->orderBy('FechaEmision', 'desc')->get();

    $notas_de_credito = $this->filtrar(
        $this->cliente->notasDeCredito(),
        $this->nc_desde,
        $this->nc_hasta
    )->orderBy('FechaEmision', 'desc')->get();

    $notas_de_debito = $this->filtrar(
        $this->cliente->notasDeDebito(),
        $this->nd_desde,
        $this->nd_hasta
    )->orderBy('FechaEmision', 'desc')->get();

    $minutas = $this->filtrar(
        $this->cliente->minutas(),
        $this->min_desde,
        $this->min_hasta
    )->orderBy('FechaEmision', 'desc')->get();

    $facturas_pendientes = $this->filtrar(
        FacturaVenta::where('IdCliente', $this->cliente->id)
            ->where('Estado', 'PENDIENTE'),
        $this->fact_desde,
        $this->fact_hasta
    )->orderBy('FechaEmision', 'desc')->get();

    $facturas_pendientes_completas = $this->filtrar(
        FacturaVenta::where('IdCliente', $this->cliente->id),
        $this->fact_desde,
        $this->fact_hasta
    )->orderBy('FechaEmision', 'desc')->get();

    return view('livewire.ficha-del-cliente-show2', [
        'ordenes_trabajo'  => $ordenes_trabajo,
        'notas_de_envio'   => $notas_de_envio,
        'facturas'         => $facturas,
        'recibos'          => $recibos,
        'notas_de_credito' => $notas_de_credito,
        'notas_de_debito'  => $notas_de_debito,
        'minutas'          => $minutas,
        'facturas_pendientes' => $facturas_pendientes,
        'facturas_pendientes_completas' => $facturas_pendientes_completas,
        'saldo' => $this->saldo,
    ]);
}
}
