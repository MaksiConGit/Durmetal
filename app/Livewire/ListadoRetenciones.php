<?php

namespace App\Livewire;

use App\Models\ReciboVenta;
use Livewire\Component;

class ListadoRetenciones extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $retencion_id = 1;

    public function mount()
    {
        $hoy = now()->toDateString();
        $this->fecha_fin = $hoy;
        $this->fecha_inicio = now()->subMonth()->toDateString();
    }

    public function getRecibosProperty()
    {
        $query = ReciboVenta::query();

        if ($this->fecha_inicio) {
            $query->whereDate('FechaEmision', '>=', $this->fecha_inicio);
        }

        if ($this->fecha_fin) {
            $query->whereDate('FechaEmision', '<=', $this->fecha_fin);
        }

        return $query->orderBy('FechaEmision', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.listado-retenciones', [
            'recibos_venta' => $this->recibos,
        ]);
    }
}
