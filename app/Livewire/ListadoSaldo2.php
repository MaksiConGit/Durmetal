<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\FacturaVenta;
use App\Models\NotaEnvio;
use App\Models\ReciboVenta;
use App\Models\NotaCreditoVenta;
use Carbon\Carbon;
use Livewire\Component;

// ListadoSaldo2.php
class ListadoSaldo2 extends Component
{
    public $lista_desde = '';
    public $lista_hasta = '';
    public $hasta_fecha = null;
    public $incluir_saldos = false;
    public $clienteSeleccionado = null; // <-- cliente seleccionado
    
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
        $query = Client::query();

        if (!empty($this->lista_desde)) {
            $query->where('Nombre', '>=', $this->lista_desde);
        }
        if (!empty($this->lista_hasta)) {
            $query->where('Nombre', '<=', $this->lista_hasta . 'z');
        }

        $clientes = $query->get();

        foreach ($clientes as $cliente) {
            $recibo_total = ReciboVenta::where('IdCliente', $cliente->id)
                ->whereDate('FechaEmision', '<=', $this->hasta_fecha)
                ->sum('Total');

            $nota_credito_total = NotaCreditoVenta::where('IdCliente', $cliente->id)
                ->whereDate('FechaEmision', '<=', $this->hasta_fecha)
                ->sum('Total');

            $factura_total = FacturaVenta::where('IdCliente', $cliente->id)
                ->whereDate('FechaEmision', '<=', $this->hasta_fecha)
                ->sum('Total');

            $cliente->saldo = $cliente->SaldoSistemaAnterior
                - $recibo_total
                + $factura_total
                - $nota_credito_total;

            $factura_mas_atrasada = FacturaVenta::where('IdCliente', $cliente->id)
                ->where('Estado', 'PENDIENTE')
                ->whereDate('FechaEmision', '<=', $this->hasta_fecha)
                ->orderBy('FechaVencimiento', 'asc')
                ->select('FechaEmision', 'FechaVencimiento')
                ->first();

            $cliente->factura_atrasada_emision = $factura_mas_atrasada->FechaEmision ?? null;
            $cliente->factura_atrasada_vencimiento = $factura_mas_atrasada->FechaVencimiento ?? null;
        }

        if (!$this->incluir_saldos) {
            $clientes = $clientes->filter(fn($c) => $c->saldo != 0)->values();
        }

        return view('livewire.listado-saldo2', compact('clientes'));
    }
}
