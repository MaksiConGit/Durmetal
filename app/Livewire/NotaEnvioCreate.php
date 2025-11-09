<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use App\Models\NotaEnvio;
use App\Models\PuntoDeVenta;
use App\Models\CodigoComplejidad;
use Carbon\Carbon;
use Livewire\Component;

class NotaEnvioCreate extends Component
{
    public $items_orden_trabajo;
    public $next_nota_numero;
    public $cliente;
    public $pto_ventas;
    public $fechaEmision;
    public $descripcion = [];
    public $precio_unitario = [];
    public $total = [];
    public $codigo_complejidad = [];
    public $codigo_invalido = [];
    public $descuento = [];
    public $seleccionados = [];
    public $subtotal = 0;
    public $base_imponible = 0;
    public $porcentaje_descuento = 0;
    public $iva = 0;
    public $total_final = 0;
    public $coeficiente = [];

    public function mount()
    {
        $this->fechaEmision = Carbon::today()->format('Y-m-d');
        $this->pto_ventas = PuntoDeVenta::all();

        $this->items_orden_trabajo = ItemOrdenTrabajo::whereHas('ordenTrabajo', function ($q) {
                $q->where('IdCliente', $this->cliente->id)
                  ->where('Estado', 'PENDIENTE');
            })
            ->where('Estado', 'APROBADO')
            ->where('ConNotaEnvio', false)
            ->get();

        $this->next_nota_numero = NotaEnvio::max('Numero') + 1;

        foreach ($this->items_orden_trabajo as $item) {
            $codigo = $item->codigoComplejidad;
            $precio = $codigo->Precio ?? 0;
            $coef = $codigo->Coeficiente ?? 1;
            $this->codigo_complejidad[$item->id] = $item->CodigoComplejidad;
            $this->precio_unitario[$item->id] = $precio;
            $this->coeficiente[$item->id] = $coef;
            $this->descuento[$item->id] = 0;
            $this->total[$item->id] = $precio * $item->Peso;
            $this->codigo_invalido[$item->id] = false;
        }

    }

    public function onCodigoComplejidadChange($id, $nuevoCodigo)
    {
        $this->codigo_complejidad[$id] = $nuevoCodigo;

        $item = $this->items_orden_trabajo->firstWhere('id', $id);

        $codigo = CodigoComplejidad::where('CC', $nuevoCodigo)->first();

        if ($codigo) {
            $this->codigo_invalido[$id] = false;
            $this->precio_unitario[$id] = $codigo->Precio;
            $this->total[$id] = $codigo->Precio * ($item->Peso ?? 0);
            $this->coeficiente[$id] = $codigo->Coeficiente;
        } else {
            $this->codigo_invalido[$id] = true;
            $this->precio_unitario[$id] = 0;
            $this->total[$id] = 0;
            $this->coeficiente[$id] = 0;
        }

        $this->actualizarSubtotal();
    }

    public function updatedDescuento($value, $key)
    {
        $id = $key;
        $item = $this->items_orden_trabajo->firstWhere('id', $id);

        $peso = $item->Peso ?? 0;
        $precio = $this->precio_unitario[$id] ?? 0;
        $descuento = max(0, min((float)$value, 100));

        $this->total[$id] = ($precio * $peso) * (1 - $descuento / 100);
            $this->actualizarSubtotal();

    }

    public function updatedSeleccionados($value, $key)
    {
        $id = (int) $key;

        $item = $this->items_orden_trabajo->firstWhere('id', $id);

        if (!$item) return;

        if (!empty($this->seleccionados[$id]) && $this->seleccionados[$id]) {
            $tratamiento = $item->tratamiento->Nombre ?? '';
            $material = $item->material->Nombre ?? '';
            $descripcionOriginal = $item->Descripcion ?? '';
            $remito = $item->ordenTrabajo->NumeroRemitoCliente ?? '';

            $this->descripcion[$id] = "{$tratamiento}-{$material}-{$descripcionOriginal}-???? {$remito}";
        }
        else {
            $this->descripcion[$id] = $item->Descripcion ?? '';
        }

        $this->actualizarSubtotal();
    }

    public function updatedTotal()
    {
        $this->actualizarSubtotal();
    }

    public function actualizarSubtotal()
    {
        $this->subtotal = 0;

        foreach ($this->items_orden_trabajo as $item) {
            $id = $item->id;
            if (!empty($this->seleccionados[$id]) && $this->seleccionados[$id]) {
                $this->subtotal += $this->total[$id] ?? 0;
            }
        }
        
        $this->onPorcentajeDescuentoChange($this->porcentaje_descuento);
    }

    public function onPrecioChange($id, $value)
    {
        $peso = $this->items_orden_trabajo->find($id)->Peso ?? 0;
        $this->total[$id] = floatval($value) * floatval($peso);

        $this->actualizarSubtotal();
    }

public function onPorcentajeDescuentoChange($value)
{
    $porcentaje = floatval($value);

    $this->base_imponible = $this->subtotal - ($this->subtotal * ($porcentaje / 100));

    $this->iva = $this->base_imponible * 0.21;

    $this->total_final = $this->base_imponible + $this->iva;
}

    public function render()
    {
        return view('livewire.nota-envio-create');
    }
}
