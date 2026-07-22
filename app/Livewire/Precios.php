<?php

namespace App\Livewire;

use App\Models\CodigoComplejidad;
use Livewire\Component;

class Precios extends Component
{
    public $codigos_complejidad = [];
    public $tratamiento;
    public $activeTab = 'custom-tabs-2';
    public $selectedCodigo;
    public $selectedItem = null;
    public $seleccionados = [];

    public $Multiplicador = 1;
    public $Redondeo = 1;

    public $precio_nuevo = [];
    public $diferencia = [];
    public $coef_nuevo = [];
    public $editPrecio;
    public $editPorcentaje;
    public $editCoeficiente;

    public $createPrecio;
    public $createPorcentaje;
    public $createCoeficiente;

    public function mount()
    {
        $this->codigos_complejidad = CodigoComplejidad::where('IdTratamiento', $this->tratamiento->id)->orderBy('CC')->get();


        if (session()->has('IdCodigoComplejidad')) {
            $this->selectedCodigo = CodigoComplejidad::find(session('IdCodigoComplejidad'));
        }
        else{
        $this->selectedCodigo = CodigoComplejidad::first();
            
        }

    }

    public function updatedCreatePrecio()
    {
        $this->recalcularCreate();
    }

    public function updatedCreatePorcentaje()
    {
        $this->recalcularCreate();
    }

    public function recalcularCreate()
    {
        if ($this->createPrecio !== null && $this->createPorcentaje !== null) {
            $this->createCoeficiente = round(
                floatval($this->createPrecio) * (floatval($this->createPorcentaje) / 100),
                2
            );
        }
    }

    public function selectItem($id)
    {
        $this->selectedItem = $id;
        $this->selectedCodigo = CodigoComplejidad::find($this->selectedItem);

        $this->editPrecio = $this->selectedCodigo->Precio;
        $this->editPorcentaje = $this->selectedCodigo->PorcentajeCoeficiente;
        $this->editCoeficiente = $this->selectedCodigo->Coeficiente;
    }

    public function updatedEditPrecio()
    {
        $this->recalcularCoeficiente();
    }

    public function updatedEditPorcentaje()
    {
        $this->recalcularCoeficiente();
    }

    public function recalcularCoeficiente()
    {
        if ($this->editPrecio !== null && $this->editPorcentaje !== null) {
            $this->editCoeficiente = round(
                floatval($this->editPrecio) * (floatval($this->editPorcentaje) / 100),
                2
            );
        }
    }

    public function deleteItem($id)
    {
        if (!$id) return;

        $codigo_complejidad = CodigoComplejidad::find($id);
        if ($codigo_complejidad) {
            $codigo_complejidad->delete();
            $this->selectedItem = null;
        }
    }

    public function setActiveTab($tabId)
    {
        $this->activeTab = $tabId;
    }

    public function getHaySeleccionadosProperty()
    {
        return collect($this->seleccionados)->contains(true);
    }

    public function seleccionarTodo()
    {
        foreach ($this->codigos_complejidad as $item) {
            $id = $item->id;
            $this->seleccionados[$id] = true;
        }

        $this->calcular();
    }

    public function deseleccionarTodo()
    {
        foreach ($this->codigos_complejidad as $item) {
            $id = $item->id;
            $this->seleccionados[$id] = false;
        }
    }

    public function updatedMultiplicador()
    {
        $this->calcular();
    }

    public function updatedRedondeo()
    {
        $this->calcular();
    }

    public function updatedSeleccionados()
    {
        $this->calcular();
    }

    public function calcular()
    {
        foreach ($this->codigos_complejidad as $item) {
            $id = $item->id;

            if (!isset($this->seleccionados[$id]) || !$this->seleccionados[$id]) {
                $this->precio_nuevo[$id] = null;
                $this->diferencia[$id] = null;
                $this->coef_nuevo[$id] = null;
                continue;
            }

            $precio = floatval($item->Precio);
            $coef = floatval($item->Coeficiente);

            $nuevo = $precio * floatval($this->Multiplicador);

            if ($this->Redondeo > 0) {
                $multiplo = $this->Redondeo;
                $nuevo = round($nuevo / $multiplo) * $multiplo;
            }

            $this->precio_nuevo[$id]   = $nuevo;
            $this->diferencia[$id]     = $nuevo - $precio;
            $this->coef_nuevo[$id]     = $coef * floatval($this->Multiplicador);
        }
    }

    public function render()
    {
        return view('livewire.precios');
    }
}
