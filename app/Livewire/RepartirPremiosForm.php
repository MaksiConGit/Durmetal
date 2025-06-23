<?php

namespace App\Livewire;

use Livewire\Component;

class RepartirPremiosForm extends Component
{
    public $empleados = [];

    public $bases = [];
    public $coeficientes = [];
    public $premios = [];
    public $total = 0;

    public $indiceBasePremios = [];
    public $totalPremios = 0;

    public function mount($empleados, $total = 0)
    {
        $this->empleados = $empleados;
        $this->total = floatval($total);

        $cantidad = count($empleados);
        $base_individual = $cantidad > 0 ? $this->total / $cantidad : 0;

        foreach ($empleados as $empleado) {
            $id = $empleado->id;
            $this->bases[$id] = number_format($base_individual, 2, '.', '');
            $this->coeficientes[$id] = number_format(1, 2, '.', '');
            $this->indiceBasePremios[$id] = number_format($empleado->IndiceBasePremio ?? 0, 2, '.', '');
            $this->premios[$id] = $base_individual * $this->indiceBasePremios[$id] * $this->coeficientes[$id];
        }

        $this->recalcularTotal();
    }



    public function updatedBases()
    {
        $this->recalcularPremios();
    }

    public function updatedCoeficientes()
    {
        $this->recalcularPremios();
    }

    public function updatedIndiceBasePremios()
    {
        $this->recalcularPremios();
    }

    public function recalcularPremios()
    {
        foreach ($this->empleados as $empleado) {
            $id = $empleado->id;
            $base = floatval($this->bases[$id] ?? 0);
            $indice = floatval($this->indiceBasePremios[$id] ?? 0);
            $coef = floatval($this->coeficientes[$id] ?? 1);

            $this->premios[$id] = $base * $indice * $coef;
        }

        $this->recalcularTotal();
    }

    public function recalcularTotal()
    {
        $this->totalPremios = array_sum($this->premios);
    }

    public function render()
    {
        return view('livewire.repartir-premios-form');
    }
}