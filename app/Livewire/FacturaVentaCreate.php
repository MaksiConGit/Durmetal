<?php

namespace App\Livewire;

use App\Models\NotaEnvio;
use App\Models\PuntoDeVenta;
use App\Models\CodigoComplejidad;
use App\Models\CondicionVenta;
use App\Models\FacturaVenta;
use Carbon\Carbon;
use Livewire\Component;

class FacturaVentaCreate extends Component
{
    public $notas_envio;
    public $next_factura_numero;
    public $cliente;
    public $pto_ventas;
    public $condiciones_venta;
    public $fechaEmision;
    public $fechaVencimiento;
    public $descripcion = [];
    public $total = [];
    public $IVA = [];
    public $seleccionados = [];
    public $subtotal = 0;
    public $iva = 0;
    public $total_final = 0;

    public function mount()
    {
        $this->fechaEmision = Carbon::today()->format('Y-m-d');
        $this->fechaVencimiento = Carbon::today()->addDays(7)->format('Y-m-d');
        $this->pto_ventas = PuntoDeVenta::all();
        $this->condiciones_venta = CondicionVenta::all();

        $this->notas_envio = NotaEnvio::where('IdCliente', $this->cliente->id)->where('Estado', 'PENDIENTE')->get();

        $this->next_factura_numero = FacturaVenta::max('Numero') + 1;

        foreach ($this->notas_envio as $item) {
            $this->total[$item->id] = $item->Neto;
            $this->IVA[$item->id] = $item->Neto * 0.21;
        }
    }

    public function setFechaVencimiento()
    {
        if($this->fechaEmision) {
            $this->fechaVencimiento = Carbon::parse($this->fechaEmision)
                                            ->addDays(7)
                                            ->format('Y-m-d');
        } else {
            $this->fechaVencimiento = Carbon::today()->addDays(7)->format('Y-m-d');
        }
    }

    public function updatedSeleccionados($value, $key)
    {
        $id = (int) $key;

        $item = $this->notas_envio->firstWhere('id', $id);

        if (!$item) return;

        if (!empty($this->seleccionados[$id]) && $this->seleccionados[$id]) {
            $numeroCompleto = $item->NumeroCompleto;

            if (preg_match('/^NE\s+([A-Z])\s+(.+)$/', $numeroCompleto, $matches)) {
                $letra = $matches[1];
                $numero = $matches[2];
            } else {
                $numero = '¡¡ERROR!! ¡¡REVISAR!!';
            }

            $this->descripcion[$id] = "CORRESPONDE A NOTA DE ENVIO {$numero}";
        }
        $this->actualizarSubtotal();
    }

    public function actualizarSubtotal()
    {
        $this->subtotal = 0;

        foreach ($this->notas_envio as $item) {
            $id = $item->id;
            if (!empty($this->seleccionados[$id]) && $this->seleccionados[$id]) {
                $this->subtotal += $this->total[$id] ?? 0;
            }
        }

        $this->actualizarIVATotal();
    }

    public function actualizarIVATotal()
    {
        $this->iva = $this->subtotal * 0.21;

        $this->total_final = $this->subtotal + $this->iva;
    }

    public function updatedTotal()
    {
        $this->actualizarSubtotal();
    }

    public function render()
    {
        return view('livewire.factura-venta-create');
    }
}
