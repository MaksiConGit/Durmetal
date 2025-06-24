<?php

namespace App\Livewire;

use Livewire\Component;

class CodigoComplejidad extends Component
{
    public $precio = null;
    public $porcentaje = null;
    public $coeficiente = null;

    public $tratamiento;
    public $nextCodigo;

    public function mount($tratamiento = null, $nextCodigo = null)
    {
        $this->tratamiento = $tratamiento;
        $this->nextCodigo = $nextCodigo;
    }

    public function updatedPrecio()
    {
        $this->actualizarCoeficiente();
    }

    public function updatedPorcentaje()
    {
        $this->actualizarCoeficiente();
    }

    public function updatedCoeficiente()
    {
        $this->actualizarPorcentaje();
    }

    public function actualizarCoeficiente()
    {
        $this->coeficiente = number_format($this->precio * ($this->porcentaje / 100), 3, '.', '');
    }

    public function actualizarPorcentaje()
    {
        $this->porcentaje = number_format($this->precio != 0 ? ($this->coeficiente / $this->precio) * 100 : 0, 2, '.', '');
    }

    public function render()
    {
        return view('livewire.codigo-complejidad');
    }
}
