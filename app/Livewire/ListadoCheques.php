<?php

namespace App\Livewire;

use App\Models\Chequecobro;
use App\Models\DestinoCheque;
use Livewire\Component;
use Carbon\Carbon;

class ListadoCheques extends Component
{
    public $cliente_desde;
    public $cliente_hasta;

    public $cheques_cobro;
    public $destinos_cheque;

    public $destinosSeleccionados = [];

    public function mount()
    {
        $this->cliente_desde = now()->subMonth(3)->toDateString();
        $this->cliente_hasta = now()->toDateString();

        $this->loadCheques();
    }

    public function loadCheques()
    {
        $this->cheques_cobro = Chequecobro::with(['banco', 'cobro.reciboVenta'])->get();
        $this->destinos_cheque = DestinoCheque::all();

        foreach ($this->cheques_cobro as $cheque) {
            $this->destinosSeleccionados[$cheque->id] = $cheque->IdDestinoCheque;
        }
    }

    public function updatedDestinosSeleccionados($value, $key)
    {
        $cheque = Chequecobro::find($key);
        if ($cheque) {
            $cheque->IdDestinoCheque = $value;
            $cheque->save();
        }
    }

    public function updatedClienteDesde() { $this->filtrarCheques(); }
    public function updatedClienteHasta() { $this->filtrarCheques(); }

    public function filtrarCheques()
    {
        $this->cheques_cobro = Chequecobro::with(['banco', 'cobro.reciboVenta'])
            ->whereBetween('FechaEmision', [$this->cliente_desde, $this->cliente_hasta])
            ->get();

        foreach ($this->cheques_cobro as $cheque) {
            $this->destinosSeleccionados[$cheque->id] = $cheque->IdDestinoCheque;
        }
    }

    public function render()
    {
        return view('livewire.listado-cheques', [
            'cheques_cobro' => $this->cheques_cobro,
            'destinos_cheque' => $this->destinos_cheque,
        ]);
    }
}