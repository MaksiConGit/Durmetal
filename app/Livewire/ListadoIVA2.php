<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PuntoDeVenta;
use App\Models\Arti;
use App\Models\FacturaVenta;
use App\Models\NotaCreditoVenta;
use Carbon\Carbon;

class ListadoIVA2 extends Component
{
    public $fecha_desde;
    public $fecha_hasta;

    public $total_neto = 0;
    public $total_iva = 0;
    public $total_total = 0;
    public $total_no_gravado = 0;
    public $total_exento = 0;

    public $totales_por_condicion = [];

    public $puntos_venta_seleccionados = [];

    public $activeTabParametros = 'custom-tabs-1';
    public $activeTabDocumentos = 'custom-tabs-4';

    public function setActiveTabParametros($tabId)
    {
        $this->activeTabParametros = $tabId;
    }

    public function setActiveTabDocumentos($tabId)
    {
        $this->activeTabDocumentos = $tabId;
    }


    public function mount()
    {
        $this->fecha_hasta = now()->toDateString();
        $this->fecha_desde = now()->toDateString();
    }

    public function getDocumentosProperty()
    {
        $facturas = FacturaVenta::where('EsNotaDeDebito', 0)
            ->when($this->fecha_desde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fecha_hasta))
            ->when(count($this->puntos_venta_seleccionados) > 0, fn($q) =>
                $q->whereIn('PuntoVenta', $this->puntos_venta_seleccionados)
            );

        $notas_credito = NotaCreditoVenta::query()
            ->when($this->fecha_desde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fecha_hasta))
            ->when(count($this->puntos_venta_seleccionados) > 0, fn($q) =>
                $q->whereIn('PuntoVenta', $this->puntos_venta_seleccionados)
            );

        $notas_debito = FacturaVenta::where('EsNotaDeDebito', 1)
            ->when($this->fecha_desde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fecha_hasta))
            ->when(count($this->puntos_venta_seleccionados) > 0, fn($q) =>
                $q->whereIn('PuntoVenta', $this->puntos_venta_seleccionados)
            );

        $documentos = $facturas->get()
            ->concat($notas_credito->get())
            ->concat($notas_debito->get())
            ->sortBy('FechaEmision')
            ->values();

        $this->total_neto = $this->total_iva = $this->total_total = 0;
        $this->total_no_gravado = $this->total_exento = 0;

        $condiciones = [
            'Cons. final',
            'Exento',
            'Resp. inscripto',
            'Resp. monotributo',
        ];

        foreach ($condiciones as $c) {
            $this->totales_por_condicion[$c] = [
                'no_gravado' => 0,
                'exento' => 0,
                'neto' => 0,
                'iva' => 0,
                'total' => 0,
            ];
        }

        foreach ($documentos as $doc) {
            $condicion = $doc->condicionIVA->Nombre ?? 'Desconocido';
            $factor = $doc instanceof FacturaVenta ? 1 : -1;

            $this->total_no_gravado += $factor * ($doc->NetoNoGravado ?? 0);
            $this->total_exento     += $factor * ($doc->Exento ?? 0);
            $this->total_neto       += $factor * $doc->Neto;
            $this->total_iva        += $factor * $doc->IVA;
            $this->total_total      += $factor * $doc->Total;

            if (!isset($this->totales_por_condicion[$condicion])) {
                $this->totales_por_condicion[$condicion] = [
                    'no_gravado' => 0,
                    'exento' => 0,
                    'neto' => 0,
                    'iva' => 0,
                    'total' => 0,
                ];
            }

            $this->totales_por_condicion[$condicion]['no_gravado'] += $factor * ($doc->NetoNoGravado ?? 0);
            $this->totales_por_condicion[$condicion]['exento']     += $factor * ($doc->Exento ?? 0);
            $this->totales_por_condicion[$condicion]['neto']       += $factor * $doc->Neto;
            $this->totales_por_condicion[$condicion]['iva']        += $factor * $doc->IVA;
            $this->totales_por_condicion[$condicion]['total']      += $factor * $doc->Total;
        }

        return $documentos;
    }

    public function render()
    {
        return view('livewire.listado-i-v-a2', [
            'pto_ventas' => PuntoDeVenta::all(),
            'articulos' => Arti::all(),
            'documentos' => $this->documentos,
            'total_neto' => $this->total_neto,
            'total_iva' => $this->total_iva,
            'total_total' => $this->total_total,
            'total_no_gravado' => $this->total_no_gravado,
            'total_exento' => $this->total_exento,
            'totales_por_condicion' => $this->totales_por_condicion,
        ]);
    }
}
