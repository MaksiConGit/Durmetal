<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\FacturaVenta;
use App\Models\NotaEnvio;
use Livewire\Component;

class FichaDelClienteShow2 extends Component
{
    public $activeTabParametros = 'custom-tabs-1';
    public $cliente;
    public $selectedId = 1;
    public $expanded = [];
    public $factura_venta_id = null;
    public $factura_venta = null;
    public $pendientes = 0;
    public $notaEnvio;

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

    public function mount(Client $cliente)
    {
        $this->cliente = $cliente;
        $this->factura_venta_id = 1;
        $this->notaEnvio = NotaEnvio::find($this->selectedId);
    }

    public function setActiveTabParametros($tabId)
    {
        $this->activeTabParametros = $tabId;
    }

    public function render()
    {
        $ordenes_trabajo   = $this->cliente->ordenesTrabajo;
        $notas_de_envio    = $this->cliente->notasDeEnvio;
        $facturas          = $this->cliente->facturasVenta;
        $recibos           = $this->cliente->recibosVenta;
        $notas_de_credito  = $this->cliente->notasDeCredito;
        $notas_de_debito   = $this->cliente->facturasVenta->where('EsNotaDeDebito', 1);
        $minutas           = $this->cliente->minutas;
        $facturas_pendientes = FacturaVenta::where('IdCliente', $this->cliente->id)->where('Estado', 'PENDIENTE')->get();
        $facturas_pendientes_completas = FacturaVenta::where('IdCliente', $this->cliente->id)->get();

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
        ]);
    }
}
