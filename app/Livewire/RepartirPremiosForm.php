<?php

namespace App\Livewire;

use Livewire\Component;

class RepartirPremiosForm extends Component
{
    public $empleados = [];

    public $bases = [];
    public $coeficientes = [];
    public $premios = [];

    public $indiceBasePremios = [];
    public $totalPremios = 0;

    public function mount($empleados)
    {
        $this->empleados = $empleados;

        foreach ($empleados as $empleado) {
            $id = $empleado->id;
            $this->bases[$id] = null;
            $this->coeficientes[$id] = number_format(1, 2, '.', '');
            $this->indiceBasePremios[$id] = number_format($empleado->IndiceBasePremio ?? 0, 2, '.', '');
            $this->premios[$id] = 0;
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