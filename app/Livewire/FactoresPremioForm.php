<?php

namespace App\Livewire;

use Livewire\Component;

class FactoresPremioForm extends Component
{
    public $factores = [];
    public $valores = [];
    public $activos = [];
    public $usuario;

    // Variable para controlar si la fila está expandida o no
    public $expandido = false;

    public function mount($factoresPremioUsuario, $factoresPremio, $usuario)
    {
        $this->usuario = $usuario;

        foreach ($factoresPremio as $factor) {
            $key = $factor->id;

            $this->factores[$key] = $factor;

            $valor = optional($factoresPremioUsuario->firstWhere('IdFactorPremio', $key))->Valor
                ?? $factor->ValorPredeterminado;

            $this->valores[$key] = number_format($valor, 2, '.', '');
            $this->activos[$key] = $factoresPremioUsuario->contains('IdFactorPremio', $key);
        }
    }

    public function updatedActivos()
    {
        // Reactividad automática
    }

    public function updatedValores()
    {
        // Reactividad automática
    }

    public function getPromedioProperty()
    {
        $total = 0;
        $count = 0;

        foreach ($this->activos as $index => $activo) {
            if ($activo) {
                $valor = floatval(str_replace(',', '.', $this->valores[$index]));
                $total += $valor;
                $count++;
            }
        }

        return $count > 0 ? number_format($total / $count, 2, '.', '') : 0.00;
    }

    // Método para alternar expandido o no
    public function toggleExpandido()
    {
        $this->expandido = !$this->expandido;
    }

    public function render()
    {
        return view('livewire.factores-premio-form');
    }
}
