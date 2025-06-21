<?php

namespace App\Livewire;

use Livewire\Component;

class ItemProgramacionRow extends Component
{
    public $item;
    public $index;

    public $numeroProgramacionSeleccionado = 0;
    public $cantidadFinal;

    public function mount($item, $index)
    {
        $this->item = $item;
        $this->index = $index;

        $this->actualizarCantidad();
    }

    public function updatedNumeroProgramacionSeleccionado()
    {
        $this->actualizarCantidad();
    }

    public function actualizarCantidad()
    {
        $totalProgramado = $this->item->programacion
            ->where('NumeroProgramacion', '==', $this->numeroProgramacionSeleccionado)
            ->sum('Cantidad');

        $this->cantidadFinal = max(0, $this->item->Cantidad - $totalProgramado);
    }

    public function render()
    {
        $programaciones = $this->item->programacion
            ->filter(function ($p) {
                return $p->Cantidad < $this->item->Cantidad;
            })
            ->unique('NumeroProgramacion');

        return view('livewire.item-programacion-row', [
            'programaciones' => $programaciones
        ]);
    }

}