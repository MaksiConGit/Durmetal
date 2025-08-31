<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Periodo;
use Carbon\Carbon;
use Livewire\Component;

class ResumenCuentaCorriente2 extends Component
{
    public $clientes;
    public $cliente_id;
    public $cliente;

    public $cliente_desde;
    public $cliente_hasta;

    public $documentos;
    public $saldo;

    public $facturas = [];
    public $notas_de_credito = [];
    public $recibos = [];

    public $periodo_id;

    public function mount($cliente_id)
    {
        $this->clientes = Client::all();
        $this->cliente_id = $cliente_id;

        $this->cliente_desde = now()->subMonth(3)->toDateString();
        $this->cliente_hasta = now()->toDateString();

        $this->loadCliente();
    }

    public function cancelarCliente()
    {
        $this->cliente_id = null;
        $this->updatedClienteId(null);
    }

    public function updatedClienteId($value)
    {
        $cliente = Client::find($value);
        $this->loadCliente();
    }

    public function seleccionarCliente($id)
    {
        $this->cliente_id = $id;
        $this->updatedClienteId($id);
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
            $facturas = $this->cliente->facturasVenta()
                ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
                ->get()
                ->map(fn($doc) => ['tipo' => 'factura', 'documento' => $doc, 'FechaEmision' => $doc->FechaEmision]);

            $recibos = $this->cliente->recibosVenta()
                ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
                ->get()
                ->map(fn($doc) => ['tipo' => 'recibo', 'documento' => $doc, 'FechaEmision' => $doc->FechaEmision]);

            $notas = $this->cliente->notasDeCredito()
                ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
                ->get()
                ->map(fn($doc) => ['tipo' => 'nota', 'documento' => $doc, 'FechaEmision' => $doc->FechaEmision]);

            $todosDocumentos = collect()
                ->merge($facturas)
                ->merge($recibos)
                ->merge($notas);

            $this->documentos = $todosDocumentos->sortBy('FechaEmision')->values();

            $this->saldo = $this->cliente->SaldoSistemaAnterior;
            foreach ($this->documentos as $item) {
                if ($item['tipo'] === 'factura') {
                    $this->saldo += $item['documento']->Total;
                } elseif ($item['tipo'] === 'recibo' || $item['tipo'] === 'nota') {
                    $this->saldo -= $item['documento']->Total;
                }
            }

        } else {
            $this->documentos = collect();
            $this->saldo = 0;
        }
    }

    public function seleccionarPeriodo($id)
    {
        $this->periodo_id = $id; // guardamos el id seleccionado

        $hoy = now();

        switch ($id) {
            case 1:
                $this->cliente_desde = $hoy->toDateString();
                $this->cliente_hasta = $hoy->toDateString();
                break;
            case 2:
                $this->cliente_desde = $hoy->subDays(6)->toDateString();
                $this->cliente_hasta = $hoy->toDateString();
                break;
            case 3:
                $this->cliente_desde = $hoy->subDays(29)->toDateString();
                $this->cliente_hasta = $hoy->toDateString();
                break;
            case 4:
                $this->cliente_desde = $hoy->subDays(59)->toDateString();
                $this->cliente_hasta = $hoy->toDateString();
                break;
            case 5:
                $this->cliente_desde = $hoy->subDays(89)->toDateString();
                $this->cliente_hasta = $hoy->toDateString();
                break;
            case 6:
                $this->cliente_desde = now()->startOfYear()->toDateString();
                $this->cliente_hasta = now()->startOfYear()->addMonths(2)->endOfMonth()->toDateString();
                break;
            case 7:
                $this->cliente_desde = now()->startOfYear()->addMonths(3)->startOfMonth()->toDateString();
                $this->cliente_hasta = now()->startOfYear()->addMonths(5)->endOfMonth()->toDateString();
                break;
            case 8:
                $this->cliente_desde = now()->startOfYear()->addMonths(6)->startOfMonth()->toDateString();
                $this->cliente_hasta = now()->startOfYear()->addMonths(8)->endOfMonth()->toDateString();
                break;
            case 9:
                $this->cliente_desde = now()->startOfYear()->addMonths(9)->startOfMonth()->toDateString();
                $this->cliente_hasta = now()->endOfYear()->toDateString();
                break;
            default:
                $this->cliente_desde = $hoy->toDateString();
                $this->cliente_hasta = $hoy->toDateString();
        }

        $this->filtrarMovimientos();
    }

    public function cancelarPeriodo()
    {
        $this->periodo_id = null;
        $this->cliente_desde = now()->subMonth(3)->toDateString();
        $this->cliente_hasta = now()->toDateString();
        $this->filtrarMovimientos();
    }

    public function render()
    {
        return view('livewire.resumen-cuenta-corriente2', [
            'saldo' => $this->saldo,
            'documentos' => $this->documentos,
            'periodos' => Periodo::all(),
        ]);
    }
}
