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

    // Totales dinámicos
    public $total_neto = 0;
    public $total_iva = 0;
    public $total_total = 0;

    public function mount()
    {
        $this->fecha_hasta = now()->toDateString();
        $this->fecha_desde = now()->subDay()->toDateString();
    }

    public function getDocumentosProperty()
    {
        $facturas = FacturaVenta::where('EsNotaDeDebito', 0) // Notas de envío
            ->when($this->fecha_desde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fecha_hasta));

        $notas_credito = NotaCreditoVenta::query() // Notas de crédito
            ->when($this->fecha_desde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fecha_hasta));

        $recibos = FacturaVenta::where('EsNotaDeDebito', 1) // Recibos / notas de débito
            ->when($this->fecha_desde, fn($q) => $q->whereDate('FechaEmision', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('FechaEmision', '<=', $this->fecha_hasta));

        $documentos = $facturas->get()
            ->concat($notas_credito->get())
            ->concat($recibos->get())
            ->sortByDesc('FechaEmision')
            ->values();

        // Inicializar totales
        $this->total_neto = 0;
        $this->total_iva = 0;
        $this->total_total = 0;

        foreach ($documentos as $doc) {
            if ($doc instanceof FacturaVenta) {
                // Nota de envío → sumar
                $this->total_neto += $doc->Neto;
                $this->total_iva += $doc->IVA;
                $this->total_total += $doc->Total;
            } else {
                // Nota de crédito o recibo → restar
                $this->total_neto -= $doc->Neto;
                $this->total_iva -= $doc->IVA;
                $this->total_total -= $doc->Total;
            }
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
        ]);
    }
}
