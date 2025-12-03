<?php

namespace App\Livewire;

use App\Models\Banco;
use App\Models\PuntoDeVenta;
use App\Models\FacturaVenta;
use App\Models\ReciboVenta;
use Carbon\Carbon;
use Livewire\Component;

class ReciboVentaCreate extends Component
{
    public $facturas_venta;
    public $next_recibo_numero;
    public $cliente;
    public $pto_ventas;
    public $fechaEmision;
    public $seleccionados = [];
    public $total_final = 0;
    public $activeTab = 'custom-tabs-1';
    public $a_cobrar = [];
    public $total_imputado = 0;
    public $filas = [];
    public $bancos;
    public $efectivo = 0;
    public $fechaEmisionCheque;
    public $fechaVencimientoCheque;
    public $cheques = [];
    public $tarjetas = [];
    public $retenciones = [
        'drei' => 0,
        'ganancias' => 0,
        'iibb' => 0,
        'iva' => 0,
        'suss' => 0,
    ];

    public $cantidad_efectivo = 0;
    public $cantidad_transferencias = 0;
    public $cantidad_cheques = 0;
    public $cantidad_tarjetas = 0;
    public $cantidad_retenciones = 0;

    public function mount()
    {
        $this->fechaEmision = Carbon::today()->format('Y-m-d');
        $this->pto_ventas = PuntoDeVenta::all();
        $this->bancos = Banco::all();

        for ($i = 0; $i < 4; $i++) {
            $this->filas[$i] = [
                'banco_id' => '',
                'monto' => '',
            ];
        }

        for ($i = 0; $i < 4; $i++) {
            $this->cheques[$i] = [
                'banco_id' => '',
                'numero' => '',
                'fecha_emision' => '',
                'fecha_vencimiento' => '',
                'plaza' => '',
                'es_echeck' => false,
                'monto' => 0,
            ];
        }

        for ($i = 0; $i < 4; $i++) {
            $this->tarjetas[$i] = [
                'descripcion' => '',
                'monto' => 0,
            ];
        }

        $this->fechaEmisionCheque = Carbon::today()->format('Y-m-d');
        $this->fechaVencimientoCheque = Carbon::today()->format('Y-m-d');

        $this->facturas_venta = FacturaVenta::where('IdCliente', $this->cliente->id)->where('Estado', 'PENDIENTE')->get();

        $this->next_recibo_numero = ReciboVenta::max('Numero') + 1;

        foreach ($this->facturas_venta as $factura_venta) {
            $this->a_cobrar[$factura_venta->id] = 0;
        }
    }

    public function updatedRetenciones()
    {
        $this->recalcularTotalFinal();
    }


    public function limpiarTarjeta($index)
    {
        $this->tarjetas[$index] = [
            'descripcion' => '',
            'monto' => 0,
        ];

        $this->recalcularTotalFinal();
    }

    public function updatedTarjetas($value)
    {
        if ($value > 0) {
            $this->cantidad_tarjetas = $this->cantidad_tarjetas + 1;
        }
        else{
            $this->cantidad_tarjetas = $this->cantidad_tarjetas - 1;
        }

        $this->recalcularTotalFinal();
    }

    public function limpiarCheque($index)
    {
        $this->cheques[$index] = [
            'banco_id' => '',
            'numero' => '',
            'fecha_emision' => '',
            'fecha_vencimiento' => '',
            'plaza' => '',
            'es_echeck' => false,
            'monto' => 0,
        ];

        $this->recalcularTotalFinal();
    }

    public function updatedCheques($value)
    {
        if ($value > 0) {
            $this->cantidad_cheques = $this->cantidad_cheques + 1;
        }
        else{
            $this->cantidad_cheques = $this->cantidad_cheques - 1;
        }

        $this->recalcularTotalFinal();
    }

    public function limpiarFila($index)
    {
        $this->filas[$index] = [
            'banco_id' => '',
            'monto' => '',
        ];

        $this->recalcularTotalFinal();
    }

    public function updatedFilas($value)
    {
        if ($value > 0) {
            $this->cantidad_transferencias = $this->cantidad_transferencias + 1;
        }
        else{
            $this->cantidad_transferencias = $this->cantidad_tarjetas - 1;
        }

        $this->total_final = 0;

        foreach ($this->filas as $fila) {
            $this->total_final += floatval($fila['monto'] ?? 0);
        }

        $this->recalcularTotalFinal();
    }

    protected function recalcularTotalFinal()
    {
        $total = 0;

        foreach ($this->filas as $fila) {
            $total += floatval($fila['monto'] ?? 0);
        }

        $total += floatval($this->efectivo ?? 0);

        $this->cantidad_cheques = 0;
        foreach ($this->cheques as $cheque) {
            $monto = floatval($cheque['monto'] ?? 0);
            if ($monto > 0) $this->cantidad_cheques++;
            $total += $monto;
        }

        $this->cantidad_tarjetas = 0;
        foreach ($this->tarjetas as $tarjeta) {
            $monto = floatval($tarjeta['monto'] ?? 0);
            if ($monto > 0) $this->cantidad_tarjetas++;
            $total += $monto;
        }

        $this->cantidad_retenciones = 0;
        foreach ($this->retenciones as $retencion) {
            $monto = floatval($retencion ?? 0);
            if ($monto > 0) $this->cantidad_retenciones++;
            $total += $monto;
        }

        $this->total_final = $total;
    }

    public function updatedEfectivo($value)
    {
        if ($value > 0) {
            $this->cantidad_efectivo = 1;
        }
        else{
            $this->cantidad_efectivo = 0;
        }

        $this->recalcularTotalFinal();
    }

    public function setActiveTab($tabId)
    {
        $this->activeTab = $tabId;
    }

    public function updatedSeleccionados($value, $key)
    {
        $id = $key;

        $factura = $this->facturas_venta->firstWhere('id', $id);

        if ($value) {
            $this->a_cobrar[$id] = $factura->Total;
        } else {
            $this->a_cobrar[$id] = null;
        }

        $this->actualizarTotalImputado();
    }

    public function actualizarTotalImputado()
    {
        $this->total_imputado = 0;

        foreach ($this->facturas_venta as $factura) {
            $id = $factura->id;

            if (!empty($this->seleccionados[$id]) && $this->seleccionados[$id]) {
                $this->total_imputado += floatval($this->a_cobrar[$id] ?? 0);
            }
        }
    }

    public function onACobrarChange($id, $value)
    {
        if (FacturaVenta::find($id)->Total < $value) {
            $this->a_cobrar[$id] = FacturaVenta::find($id)->Total;
        }
        else{
            $this->a_cobrar[$id] = $value;
        }

        $this->actualizarTotalImputado();
    }

    public function onSeleccionChange($id, $value)
    {
        if ($value) {
            $factura = $this->facturas_venta->firstWhere('id', $id);

            $this->a_cobrar[$id] = floatval($factura->Total);
        } else {
            $this->a_cobrar[$id] = 0;
        }

        $this->actualizarTotalImputado();
    }

    public function render()
    {
        return view('livewire.recibo-venta-create');
    }
}
