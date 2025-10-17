<?php

namespace App\Livewire;

use App\Models\Chequepago;
use Livewire\Component;
use Carbon\Carbon;

class ListadoChequesProveedores2 extends Component
{
    public $cliente_desde;
    public $cliente_hasta;

    public $cheques_pago;

    public function mount()
    {
        $this->cliente_desde = now()->subMonth(1)->toDateString();
        $this->cliente_hasta = now()->toDateString();
        $this->filtrarCheques();
    }

    public function updatedClienteDesde() { $this->filtrarCheques(); }
    public function updatedClienteHasta() { $this->filtrarCheques(); }

    public function filtrarCheques()
    {
        $this->cheques_pago = Chequepago::with(['banco', 'pago.ordenPago'])
            ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
            ->get();
    }

    public function render()
    {
        return view('livewire.listado-cheques-proveedores2', [
            'cheques_pago' => $this->cheques_pago,
        ]);
    }
}