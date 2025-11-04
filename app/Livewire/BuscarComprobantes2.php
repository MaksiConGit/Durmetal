<?php

namespace App\Livewire;

use App\Models\Proveedor;
use Carbon\Carbon;
use Livewire\Component;

class BuscarComprobantes2 extends Component
{
    public $documentos = [];
    public $filtroTipo = 'Todos';
    public $fechaDesde;
    public $fechaHasta;
    public $numero = '';
    public $puntoVenta = '';
    public $proveedor_id = null;

    public function mount()
    {
        $this->fechaHasta = Carbon::today()->format('Y-m-d');
        $this->fechaDesde = Carbon::today()->subMonth()->format('Y-m-d');

        $this->documentos = collect();
    }

    public function cancelarCliente()
    {
        $this->proveedor_id = null;
    }

    public function updatedClienteId($value)
    {
        $proveedor = Proveedor::find($value);
    }

    public function seleccionarCliente($id)
    {
        $proveedor = Proveedor::find($id);

        if ($proveedor) {
            $this->proveedor_id = $proveedor->id;
        }
    }

    public function getDocumentosFiltradosProperty()
    {
        $documentos = collect();

        // --- Facturas de compra ---
        if ($this->filtroTipo === 'Todos' || $this->filtroTipo === 'FacturaCompra') {
            $facturas = \App\Models\FacturaCompra::query()
                ->where('EsNotaDeDebito', 0)
                ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
                ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
                ->when($this->numero, fn($q) => $q->where('NumeroCompleto', 'like', "%{$this->numero}%"))
                ->when($this->puntoVenta, fn($q) => $q->where('PuntoVenta', 'like', "%{$this->puntoVenta}%"))
                ->when($this->proveedor_id, fn($q) => $q->where('IdProveedor', $this->proveedor_id))
                ->get();

            $documentos = $documentos->concat($facturas);
        }

        // --- Notas de débito de compra ---
        if ($this->filtroTipo === 'Todos' || $this->filtroTipo === 'NotaDebitoCompra') {
            $notasDebito = \App\Models\FacturaCompra::query()
                ->where('EsNotaDeDebito', 1)
                ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
                ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
                ->when($this->numero, fn($q) => $q->where('NumeroCompleto', 'like', "%{$this->numero}%"))
                ->when($this->puntoVenta, fn($q) => $q->where('PuntoVenta', 'like', "%{$this->puntoVenta}%"))
                ->when($this->proveedor_id, fn($q) => $q->where('IdProveedor', $this->proveedor_id))
                ->get();

            $documentos = $documentos->concat($notasDebito);
        }

        // --- Notas de crédito de compra ---
        if ($this->filtroTipo === 'Todos' || $this->filtroTipo === 'NotaCreditoCompra') {
            $notasCredito = \App\Models\NotaCreditoCompra::query()
                ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
                ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
                ->when($this->numero, fn($q) => $q->where('NumeroCompleto', 'like', "%{$this->numero}%"))
                ->when($this->puntoVenta, fn($q) => $q->where('PuntoVenta', 'like', "%{$this->puntoVenta}%"))
                ->when($this->proveedor_id, fn($q) => $q->where('IdProveedor', $this->proveedor_id))
                ->get();

            $documentos = $documentos->concat($notasCredito);
        }

        // --- Órdenes de pago ---
        if ($this->filtroTipo === 'Todos' || $this->filtroTipo === 'OrdenPago') {
            $ordenesPago = \App\Models\OrdenPago::query()
                ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
                ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
                ->when($this->numero, fn($q) => $q->where('NumeroCompleto', 'like', "%{$this->numero}%"))
                ->when($this->puntoVenta, fn($q) => $q->where('PuntoVenta', 'like', "%{$this->puntoVenta}%"))
                ->when($this->proveedor_id, fn($q) => $q->where('IdProveedor', $this->proveedor_id))
                ->get();

            $documentos = $documentos->concat($ordenesPago);
        }

        // --- Mapeo y orden ---
        return $documentos->map(function ($doc) {
            return [
                'Id' => $doc->id,
                'Tipo' => class_basename($doc),
                'FechaEmision' => $doc->FechaEmision,
                'FechaVencimiento' => $doc->FechaVencimiento ?? null,
                'NumeroCompleto' => $doc->NumeroCompleto,
                'PuntoVenta' => $doc->PuntoVenta,
                'IdProveedor' => $doc->IdProveedor,
                'RazonSocial' => $doc->RazonSocial ?? ($doc->proveedor->Nombre ?? null),
                'Estado' => $doc->Estado ?? null,
                'PorcentajeDescuento' => $doc->PorcentajeDescuento ?? null,
                'Total' => $doc->Total,
            ];
        })->sortByDesc('FechaEmision')->values();
    }

    public function getUrlEditarDocumento($documento)
    {
        $tipo = $documento['Tipo'];
        $id = $documento['Id'];

        switch ($tipo) {
            case 'FacturaCompra':
                return route('compras.ficha-del-proveedor.factura-compra.create', $id);
            case 'NotaDebitoCompra':
                return route('compras.ficha-del-proveedor.nota-debito.create', $id);
            case 'NotaCreditoCompra':
                return route('compras.ficha-del-proveedor.nota-credito.create', $id);
            case 'OrdenPago':
                return route('compras.ficha-del-proveedor.orden-pago.create', $id);
            default:
                return '#';
        }
    }

    public function render()
    {
        return view('livewire.buscar-comprobantes2', [
            'proveedores' => Proveedor::all(),
        ]);
    }
}
