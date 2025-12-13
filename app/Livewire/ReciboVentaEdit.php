<?php

namespace App\Livewire;

use App\Models\Banco;
use App\Models\PuntoDeVenta;
use App\Models\FacturaVenta;
use App\Models\ReciboVenta;
use Carbon\Carbon;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class ReciboVentaEdit extends Component
{
    public $facturas_venta;
    public $recibo_venta;
    public $items_recibo_venta;
    public $next_recibo_numero;
    public $cliente;
    public $pto_ventas;
    public $fechaEmision;
    public $seleccionados = [];
    public $total_final = 0;
    public $activeTab = 'custom-tabs-1';
    public $a_cobrar = [];
    public $total_imputado = 0;
    public $bancos;
    public $fechaEmisionCheque;
    public $fechaVencimientoCheque;
    public $efectivo = 0;
    public $efectivo_id_cobro;
    public $transferencias;
    public $filas;
    public $filas_cheques;
    public $cheques = [];
    public $tarjetas = [];
    public $filas_tarjetas;
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
        $this->fechaEmision = $this->recibo_venta->FechaEmision;
        $this->pto_ventas = PuntoDeVenta::all();
        $this->bancos = Banco::all();

        // EFECTIVO
        $this->efectivo = $this->recibo_venta->cobroEfectivo->Total ?? 0;
        $this->efectivo_id_cobro = $this->recibo_venta->cobroEfectivo->id ?? null;
        $this->cantidad_efectivo = ($this->efectivo != 0) ? 1 : 0;

        // TRANSFERENCIAS
        $this->transferencias = $this->recibo_venta->cobrosTransferencia ?? collect();
        $this->cantidad_transferencias = count($this->transferencias);

        $map = [];

        foreach ($this->transferencias as $t) {
            $map[] = [
                'id' => $t->id,
                'banco_id' => $t->transferenciaCobro->banco->id,
                'monto' => $t->Total,
            ];
        }

        $minimo = 5;

        $actual = count($map);

        if ($actual < $minimo) {
            $faltantes = $minimo - $actual;

            for ($i = 0; $i < $faltantes; $i++) {
                $map[] = [
                    'id' => null,
                    'banco_id' => '',
                    'monto' => '',
                ];
            }
        }

        $this->transferencias = $map;
        $this->filas = $map;

        // CHEQUES
        $this->cheques = $this->recibo_venta->cobrosCheque ?? collect();

        $map = [];

        foreach ($this->cheques as $c) {

            $cheque = $c->cheque ?? null;

            $map[] = [
                'id'                => $c->id,
                'id_chequecobro'    => $cheque->id ?? null,
                'banco_id'          => $cheque->IdBanco        ?? '',
                'numero'            => $cheque->Numero       ?? '',
                'fecha_emision'     => $cheque->FechaEmision ?? '',
                'fecha_vencimiento' => $cheque->FechaAcreditacion ?? Carbon::today()->format('Y-m-d'),
                'plaza'             => $cheque->Plaza        ?? '',
                'es_echeck'         => (bool) ($cheque->eCheck ?? false),
                'monto'             => $c->Total        ?? 0,
            ];
        }

        $minimo = 5;

        $actual = count($map);

        $this->cantidad_cheques = $actual;

        if ($actual < $minimo) {
            $faltantes = $minimo - $actual;

            for ($i = 0; $i < $faltantes; $i++) {
                $map[] = [
                    'id'                => null,
                    'id_chequecobro'    => null,
                    'banco_id'          => '',
                    'numero'            => '',
                    'fecha_emision'     => '',
                    'fecha_vencimiento' => Carbon::today()->format('Y-m-d'),
                    'plaza'             => '',
                    'es_echeck'         => false,
                    'monto'             => 0,
                ];
            }
        }

        $this->cheques = $map;
        $this->filas_cheques = $map;

        // TARJETAS
        $this->tarjetas = $this->recibo_venta->cobrosTarjeta ?? collect();
        $mapTarjetas = [];

        foreach ($this->tarjetas as $t) {
            $mapTarjetas[] = [
                'id'          => $t->id,
                'descripcion' => $t->Descripcion ?? '',
                'monto'       => $t->Total       ?? 0,
            ];
        }

        $minimo = 5;
        $actual = count($mapTarjetas);

        $this->cantidad_tarjetas = $actual;

        if ($actual < $minimo) {
            $faltantes = $minimo - $actual;

            for ($i = 0; $i < $faltantes; $i++) {
                $mapTarjetas[] = [
                    'id'          => null,
                    'descripcion' => '',
                    'monto'       => 0,
                ];
            }
        }

        $this->tarjetas = $mapTarjetas;
        $this->filas_tarjetas = $mapTarjetas;

        // RETENCIONES
        $this->retenciones = [
            'drei' => $this->recibo_venta->RetencionDREI,
            'ganancias' => $this->recibo_venta->RetencionGanancias,
            'iibb' => $this->recibo_venta->RetencionIIBB,
            'iva' => $this->recibo_venta->RetencionIVA,
            'suss' => $this->recibo_venta->RetencionSUSS,
        ];

        $this->cantidad_retenciones = count(array_filter($this->retenciones, function($valor) {
            return $valor != 0;
        }));

        $this->fechaEmisionCheque = Carbon::today()->format('Y-m-d');
        $this->fechaVencimientoCheque = Carbon::today()->format('Y-m-d');

        $this->facturas_venta = FacturaVenta::where('IdCliente', $this->recibo_venta->cliente->id)->where('Estado', 'PENDIENTE')->get();
        $this->items_recibo_venta = $this->recibo_venta->itemsReciboVenta;
        $this->next_recibo_numero = ReciboVenta::max('Numero') + 1;

        foreach ($this->facturas_venta as $factura_venta) {
            $this->a_cobrar['fc' .$factura_venta->id] = 0;
        }

        foreach ($this->items_recibo_venta as $item_recibo_venta) {
            if ($item_recibo_venta->FacturaVenta) {
                $factura_id = $item_recibo_venta->FacturaVenta->id;

                $this->seleccionados[$factura_id] = true;

                    $this->a_cobrar['rc' . $item_recibo_venta->id] = $item_recibo_venta->Total;
            }
        }

        $this->total_imputado = $this->items_recibo_venta->sum('Total');

        $total_efectivo = $this->efectivo ?? 0;

        $total_transferencias = array_sum(
            array_map(fn($t) => floatval($t['monto'] ?? 0), $this->transferencias)
        );

        $total_cheques = array_sum(
            array_map(fn($c) => floatval($c['monto'] ?? 0), $this->cheques)
        );

        $total_tarjetas = array_sum(
            array_map(fn($t) => floatval($t['monto'] ?? 0), $this->tarjetas)
        );

        $this->total_final =
            $total_efectivo +
            $total_transferencias +
            $total_cheques +
            $total_tarjetas;
    }

    public function updatedRetenciones()
    {
        $this->recalcularTotalFinal();
    }

    public function limpiarTarjeta($index)
    {
        $this->tarjetas[$index] = array_merge(
            $this->tarjetas[$index],
            [
                'descripcion' => '',
                'monto'       => 0,
            ]
        );

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
        $this->cheques[$index] = array_merge(
            $this->cheques[$index],
            [
                'banco_id'          => '',
                'numero'            => '',
                'fecha_emision'     => '',
                'fecha_vencimiento' => Carbon::today()->format('Y-m-d'),
                'plaza'             => '',
                'es_echeck'         => false,
                'monto'             => 0,
            ]
        );

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
        $id = intval($key);

        $item = $this->items_recibo_venta->firstWhere('FacturaVenta.id', $id);

        if ($value) {

            if ($item) {
                $this->a_cobrar['rc' . $item->id] = $item->Total;
            } else {
                $factura = $this->facturas_venta->firstWhere('id', $id);

                if ($factura) {
                    $this->a_cobrar['fc' . $id] = $factura->Total;
                }
            }

        } else {
            if ($item) {
                $this->a_cobrar['rc' . $item->id] = 0;
            } else {
                $this->a_cobrar['fc' . $id] = 0;
            }
        }

        $this->actualizarTotalImputado();
    }

    public function actualizarTotalImputado()
    {
        $this->total_imputado = 0;

        foreach ($this->facturas_venta as $factura) {
            $key = 'fc' . $factura->id;

            if (!empty($this->seleccionados[$factura->id])) {
                $this->total_imputado += floatval($this->a_cobrar[$key] ?? 0);
            }
        }

        foreach ($this->items_recibo_venta as $item) {
            $fid = $item->FacturaVenta->id;
            $key = 'rc' . $item->id;

            if (!empty($this->seleccionados[$fid])) {
                $this->total_imputado += floatval($this->a_cobrar[$key] ?? 0);
            }
        }
    }

    public function onACobrarChange($id, $value)
    {
        $factura = FacturaVenta::find($id);

        if (!$factura) return;

        $max = floatval($factura->Total);
        $value = floatval($value);

        if ($value > $max) {
            $value = $max;
        }

        $rcKey = 'rc' . $id;
        $fcKey = 'fc' . $id;

        if (array_key_exists($rcKey, $this->a_cobrar)) {
            $this->a_cobrar[$rcKey] = $value;
        }

        if (array_key_exists($fcKey, $this->a_cobrar)) {
            $this->a_cobrar[$fcKey] = $value;
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
        return view('livewire.recibo-venta-edit');
    }
}
