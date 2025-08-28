<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

class ResumenCuentaCorriente2 extends Component
{
    public $clientes;
    public $cliente_id;
    public $cliente;

    public $cliente_desde;
    public $cliente_hasta;

    public $facturas = [];
    public $notas_de_credito = [];
    public $recibos = [];

    public function mount()
    {
        $this->clientes = Client::all();
        $this->cliente_id = $this->clientes->first()?->id;

        $this->cliente_desde = now()->subMonth(3)->toDateString();
        $this->cliente_hasta = now()->toDateString();

        $this->loadCliente();
    }

    public function updatedClienteId()
    {
        $this->loadCliente();
    }

    public function updatedClienteDesde()
    {
        $this->filtrarMovimientos();
    }

    public function updatedClienteHasta()
    {
        $this->filtrarMovimientos();
    }

    private function loadCliente()
    {
        $this->cliente = Client::find($this->cliente_id);
        $this->filtrarMovimientos();
    }

    private function filtrarMovimientos()
    {
        if ($this->cliente) {
            $this->facturas = $this->cliente->facturasVenta()
                ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
                ->get();

            $this->notas_de_credito = $this->cliente->notasDeCredito()
                ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
                ->get();

            $this->recibos = $this->cliente->recibosVenta()
                ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
                ->get();
        } else {
            $this->facturas = [];
            $this->notas_de_credito = [];
            $this->recibos = [];
        }
    }

    public function render()
    {
        return view('livewire.resumen-cuenta-corriente2');
    }
}
