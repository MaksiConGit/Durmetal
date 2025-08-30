<?php

namespace App\Livewire;

use App\Models\Client;
use Carbon\Carbon;
use Livewire\Component;

class BuscarDocumentos2 extends Component
{
    public $documentos = [];
    public $filtroTipo = 'Todos';
    public $fechaDesde;
    public $fechaHasta;
    public $numero = '';
    public $puntoVenta = '';
    public $cliente_id = null;

    public function mount()
    {
        $this->fechaHasta = Carbon::today()->format('Y-m-d');
        $this->fechaDesde = Carbon::today()->subMonth()->format('Y-m-d');

        $this->documentos = collect();
    }

    public function cancelarCliente()
    {
        $this->cliente_id = null;
    }

    public function updatedClienteId($value)
    {
        $cliente = Client::find($value);
    }

    public function seleccionarCliente($id)
    {
        $cliente = Client::find($id);

        if ($cliente) {
            $this->cliente_id = $cliente->id;
        }
    }

    public function getDocumentosFiltradosProperty()
    {
        $documentos = collect();

        if ($this->filtroTipo === 'Todos' || $this->filtroTipo === 'FacturaVenta') {
            $facturas = \App\Models\FacturaVenta::query()
                ->where('EsNotaDeDebito', 0)
                ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
                ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
                ->when($this->numero, fn($q) => $q->where('NumeroCompleto', 'like', "%{$this->numero}%"))
                ->when($this->puntoVenta, fn($q) => $q->where('PuntoVenta', 'like', "%{$this->puntoVenta}%"))
                ->when($this->cliente_id, fn($q) => $q->where('IdCliente', $this->cliente_id))
                ->get();

            $documentos = $documentos->concat($facturas);
        }

        if ($this->filtroTipo === 'Todos' || $this->filtroTipo === 'NotaDebito') {
            $notasDebito = \App\Models\FacturaVenta::query()
                ->where('EsNotaDeDebito', 1)
                ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
                ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
                ->when($this->numero, fn($q) => $q->where('NumeroCompleto', 'like', "%{$this->numero}%"))
                ->when($this->puntoVenta, fn($q) => $q->where('PuntoVenta', 'like', "%{$this->puntoVenta}%"))
                ->when($this->cliente_id, fn($q) => $q->where('IdCliente', $this->cliente_id))
                ->get();

            $documentos = $documentos->concat($notasDebito);
        }

        if ($this->filtroTipo === 'Todos' || $this->filtroTipo === 'NotaEnvio') {
            $notasEnvio = \App\Models\NotaEnvio::query()
                ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
                ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
                ->when($this->numero, fn($q) => $q->where('NumeroCompleto', 'like', "%{$this->numero}%"))
                ->when($this->puntoVenta, fn($q) => $q->where('PuntoVenta', 'like', "%{$this->puntoVenta}%"))
                ->when($this->cliente_id, fn($q) => $q->where('IdCliente', $this->cliente_id))
                ->get();

            $documentos = $documentos->concat($notasEnvio);
        }

        if ($this->filtroTipo === 'Todos' || $this->filtroTipo === 'NotaCreditoVenta') {
            $notasCredito = \App\Models\NotaCreditoVenta::query()
                ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
                ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
                ->when($this->numero, fn($q) => $q->where('NumeroCompleto', 'like', "%{$this->numero}%"))
                ->when($this->puntoVenta, fn($q) => $q->where('PuntoVenta', 'like', "%{$this->puntoVenta}%"))
                ->when($this->cliente_id, fn($q) => $q->where('IdCliente', $this->cliente_id))
                ->get();

            $documentos = $documentos->concat($notasCredito);
        }

        if ($this->filtroTipo === 'Todos' || $this->filtroTipo === 'ReciboVenta') {
            $recibos = \App\Models\ReciboVenta::query()
                ->when($this->fechaDesde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fechaDesde))
                ->when($this->fechaHasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fechaHasta))
                ->when($this->numero, fn($q) => $q->where('NumeroCompleto', 'like', "%{$this->numero}%"))
                ->when($this->puntoVenta, fn($q) => $q->where('PuntoVenta', 'like', "%{$this->puntoVenta}%"))
                ->when($this->cliente_id, fn($q) => $q->where('IdCliente', $this->cliente_id))
                ->get();

            $documentos = $documentos->concat($recibos);
        }

        return $documentos->map(function($doc) {
            return [
                'Id' => $doc->id,
                'Tipo' => class_basename($doc),
                'FechaEmision' => $doc->FechaEmision,
                'FechaVencimiento' => $doc->FechaVencimiento,
                'NumeroCompleto' => $doc->NumeroCompleto,
                'PuntoVenta' => $doc->PuntoVenta,
                'IdCliente' => $doc->IdCliente,
                'RazonSocial' => $doc->RazonSocial,
                'Estado' => $doc->Estado,
                'PorcentajeDescuento' => $doc->PorcentajeDescuento,
                'Total' => $doc->Total,
            ];
        })->sortByDesc('FechaEmision')->values();
    }

    public function getUrlEditarDocumento($documento)
    {
        $tipo = $documento['Tipo'];
        $id = $documento['Id'];
        switch ($tipo) {
            case 'FacturaVenta':
                return route('ventas.ficha-del-cliente-factura-venta.create', $id);
            case 'NotaEnvio':
                return route('ventas.ficha-del-cliente-nota-envio.create', $id);
            case 'NotaDebito':
                return route('ventas.ficha-del-cliente-factura-venta.create', $id);
            case 'NotaCreditoVenta':
                return route('ventas.ficha-del-cliente-nota-credito.create', $id);
            case 'ReciboVenta':
                return route('ventas.ficha-del-cliente-recibo-venta.create', $id);
            default:
                return '#';
        }
    }

    public function render()
    {
        return view('livewire.buscar-documentos2', [
            'clientes' => Client::all(),
        ]);
    }
}
