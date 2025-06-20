<?php

namespace App\Livewire;

use Livewire\Component;

class RepartirPremiosEditForm extends Component
{
    public $empleados = [];

    public $bases = [];
    public $coeficientes = [];
    public $premios = [];

    public $indiceBasePremios = [];
    public $totalPremios = 0;
    public $items_premio = [];

    public function mount($premio, $items_premio)
    {
        $this->items_premio = $items_premio;

        foreach ($items_premio as $item) {
            $usuario = $item->usuario;
            $usuarioId = $usuario->id;

            $this->empleados[$usuarioId] = $usuario;
            $this->bases[$usuarioId] = number_format($item->PremioBase, 2, '.', '');
            $this->indiceBasePremios[$usuarioId] = number_format($item->IndiceBase, 2, '.', '');
            $this->coeficientes[$usuarioId] = number_format($item->Coeficiente, 2, '.', '');
            $this->premios[$usuarioId] = $item->Premio;
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
        return view('livewire.repartir-premios-edit-form');
    }
}