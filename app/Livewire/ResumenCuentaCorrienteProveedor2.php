<?php

namespace App\Livewire;

use App\Models\Facturacompra;
use App\Models\NotaCreditoCompra;
use App\Models\Pago;
use App\Models\Proveedor;
use App\Models\Periodo;
use Carbon\Carbon;
use Livewire\Component;

class ResumenCuentaCorrienteProveedor2 extends Component
{
    public $proveedores;
    public $proveedor_id;
    public $proveedor;

    public $cliente_desde;
    public $cliente_hasta;

    public $documentos;
    public $saldo;

    public $facturas = [];
    public $notas_de_credito = [];
    public $recibos = [];

    public $periodo_id;

    public function mount($proveedor_id = null)
    {
        $this->proveedores = Proveedor::all();
        $this->proveedor_id = $proveedor_id;

        $this->cliente_desde = now()->subMonth(3)->toDateString();
        $this->cliente_hasta = now()->toDateString();

        $this->loadCliente();
    }

    public function cancelarCliente()
    {
        $this->proveedor_id = null;
        $this->updatedClienteId(null);
    }

    public function updatedClienteId($value)
    {
        $proveedor = Proveedor::find($value);
        $this->loadCliente();
    }

    public function seleccionarCliente($id)
    {
        $this->proveedor_id = $id;
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
        $this->proveedor = Proveedor::find($this->proveedor_id);
        $this->filtrarMovimientos();
    }

    private function filtrarMovimientos()
    {
        if ($this->proveedor) {
            $facturas = Facturacompra::where('IdProveedor', $this->proveedor->id)
                ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
                ->get()
                ->map(fn($doc) => ['tipo' => 'factura', 'documento' => $doc, 'FechaEmision' => $doc->FechaEmision]);

            $pagos = Pago::whereHas('ordenPago', function ($q) {
                    $q->where('IdProveedor', $this->proveedor->id)
                    ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta]);
                })
                ->get()
                ->map(fn($doc) => [
                    'tipo' => 'pago',
                    'documento' => $doc,
                    'FechaEmision' => $doc->ordenPago->FechaEmision ?? null,
                ]);

            $notas = NotaCreditoCompra::where('IdProveedor', $this->proveedor->id)
                ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
                ->get()
                ->map(fn($doc) => ['tipo' => 'nota', 'documento' => $doc, 'FechaEmision' => $doc->FechaEmision]);

            $todosDocumentos = collect()
                ->merge($facturas)
                ->merge($pagos)
                ->merge($notas);

            $this->documentos = $todosDocumentos->sortBy('FechaEmision')->values();

            $this->saldo = $this->proveedor->SaldoSistemaAnterior ?? 0;

            foreach ($this->documentos as $item) {
                if ($item['tipo'] === 'factura') {
                    $this->saldo += $item['documento']->Total;
                } elseif ($item['tipo'] === 'pago' || $item['tipo'] === 'nota') {
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
        $this->periodo_id = $id;

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
        return view('livewire.resumen-cuenta-corriente-proveedor2', [
            'saldo' => $this->saldo,
            'documentos' => $this->documentos,
            'periodos' => Periodo::all(),
        ]);
    }
}
