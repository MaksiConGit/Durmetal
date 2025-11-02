<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PuntoDeVenta;
use App\Models\Arti;
use App\Models\Facturacompra;
use App\Models\NotaCreditoCompra;
use Carbon\Carbon;

class ListadoIVACompras2 extends Component
{
    public $fecha_desde;
    public $fecha_hasta;

    public $facturas_compra;
    public $notas_credito_compra;

    public $total_neto = 0;
    public $total_iva = 0;
    public $total_total = 0;
    public $total_no_gravado = 0;
    public $total_exento = 0;

    public $totales_por_condicion = [];

    public $puntos_venta_seleccionados = [];

    public $activeTabParametros = 'custom-tabs-1';
    public $activeTabDocumentos = 'custom-tabs-2';

    // 🔹 Subtotales por tipo de documento
    public $subtotal_fc = [
        'PercepcionIVA' => 0,
        'PercepcionIIBB' => 0,
        'PercepcionGanancias' => 0,
        'ConceptosNoGravados' => 0,
        'Sellados' => 0,
        'ImpuestoInterno' => 0,
        'AjustePorRedondeo' => 0,
        'Total' => 0,
    ];

    public $subtotal_nc = [
        'PercepcionIVA' => 0,
        'PercepcionIIBB' => 0,
        'PercepcionGanancias' => 0,
        'ConceptosNoGravados' => 0,
        'Sellados' => 0,
        'ImpuestoInterno' => 0,
        'AjustePorRedondeo' => 0,
        'Total' => 0,
    ];

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
        $facturas_compra = Facturacompra::query()
            ->when($this->fecha_desde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fecha_hasta))
            ->orderBy('FechaEmision')
            ->get();

        $notas_credito_compra = NotaCreditoCompra::query()
            ->when($this->fecha_desde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fecha_hasta))
            ->orderBy('FechaEmision')
            ->get();

        return [
            'facturas_compra' => $facturas_compra,
            'notas_credito_compra' => $notas_credito_compra,
        ];
    }

    public function render()
    {
        $documentos = $this->getDocumentosProperty();

        $this->facturas_compra = $documentos['facturas_compra'];
        $this->notas_credito_compra = $documentos['notas_credito_compra'];

        // 🔸 Calcular subtotales de Facturas
        $this->subtotal_fc = [
            'PercepcionIVA' => $this->facturas_compra->sum('PercepcionIVA'),
            'PercepcionIIBB' => $this->facturas_compra->sum('PercepcionIIBB'),
            'PercepcionGanancias' => $this->facturas_compra->sum('PercepcionGanancias'),
            'ConceptosNoGravados' => $this->facturas_compra->sum('ConceptosNoGravados'),
            'Sellados' => $this->facturas_compra->sum('Sellados'),
            'ImpuestoInterno' => $this->facturas_compra->sum('ImpuestoInterno'),
            'AjustePorRedondeo' => $this->facturas_compra->sum('AjustePorRedondeo'),
            'Total' => $this->facturas_compra->sum('Total'),
        ];

        // 🔸 Calcular subtotales de Notas de Crédito
        $this->subtotal_nc = [
            'PercepcionIVA' => $this->notas_credito_compra->sum('PercepcionIVA'),
            'PercepcionIIBB' => $this->notas_credito_compra->sum('PercepcionIIBB'),
            'PercepcionGanancias' => $this->notas_credito_compra->sum('PercepcionGanancias'),
            'ConceptosNoGravados' => $this->notas_credito_compra->sum('ConceptosNoGravados'),
            'Sellados' => $this->notas_credito_compra->sum('Sellados'),
            'ImpuestoInterno' => $this->notas_credito_compra->sum('ImpuestoInterno'),
            'AjustePorRedondeo' => $this->notas_credito_compra->sum('AjustePorRedondeo'),
            'Total' => $this->notas_credito_compra->sum('Total'),
        ];

        return view('livewire.listado-i-v-a-compras2', [
            'pto_ventas' => PuntoDeVenta::all(),
            'articulos' => Arti::all(),
            'facturas_compra' => $this->facturas_compra,
            'notas_credito_compra' => $this->notas_credito_compra,
            'total_neto' => $this->total_neto,
            'total_iva' => $this->total_iva,
            'total_total' => $this->total_total,
            'total_no_gravado' => $this->total_no_gravado,
            'total_exento' => $this->total_exento,
            'totales_por_condicion' => $this->totales_por_condicion,
            'subtotal_fc' => $this->subtotal_fc,
            'subtotal_nc' => $this->subtotal_nc,
        ]);
    }
}
