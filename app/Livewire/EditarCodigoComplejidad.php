<?php

namespace App\Livewire;

use Livewire\Component;

class EditarCodigoComplejidad extends Component
{
    public $codigo_complejidad;
    public $precio = null;
    public $porcentaje = null;
    public $coeficiente = null;

    public $tratamiento;
    public $nextCodigo;
    public $divisa;
    public $descripcion;

    public function mount($tratamiento = null, $nextCodigo = null, $codigo_complejidad = null, $divisa = null)
    {
        $this->tratamiento = $tratamiento;
        $this->nextCodigo = $nextCodigo;
        $this->codigo_complejidad = $codigo_complejidad;
        $this->nextCodigo = $codigo_complejidad->CC;
        $this->precio = $codigo_complejidad->Precio;
        $this->coeficiente = $codigo_complejidad->Coeficiente;
        $this->porcentaje = $codigo_complejidad->PorcentajeCoeficiente;
        $this->divisa = $codigo_complejidad->Divisa;
        $this->descripcion = $codigo_complejidad->Descripcion;
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
        return view('livewire.editar-codigo-complejidad');
    }
}
