<?php

namespace App\Livewire;

use App\Models\MedioEnfriamiento;
use App\Models\TipoProgramacion;
use App\Models\Tratamiento;
use App\Models\User;
use App\Models\PlantillaCarga;
use Livewire\Component;

class ProgramacionCreate2 extends Component
{
    public $items;
    public $IdTipoProgramacion;
    public $Temperatura;
    public $IdMedioEnfriamiento;
    public $bloquearHorno = false;

    public function mount($items)
    {
        $this->items = $items;
        $this->IdTipoProgramacion = old('IdTipoProgramacion', TipoProgramacion::first()?->id ?? null);
        $this->Temperatura = 0;
        $this->IdMedioEnfriamiento = 7;
  
        $this->bloquearHorno = collect($this->items)
            ->every(function ($item) {
                return in_array($item->IdTratamiento, [16, 37, 62]);
            });
    }


    public function updatedIdTipoProgramacion($value)
    {
        $materiales = collect($this->items)->pluck('IdMaterial')->unique();
        $tratamientos = collect($this->items)->pluck('IdTratamiento')->unique();

        if ($materiales->count() === 1 && $tratamientos->count() === 1) {
            $IdMaterial = $materiales->first();
            $IdTratamiento = $tratamientos->first();

            $plantilla = PlantillaCarga::where('IdMaterial', $IdMaterial)
                ->where('IdTratamiento', $IdTratamiento)->where('IdTipoProgramacion', $value)
                ->first();

            $this->Temperatura = $plantilla->Temperatura ?? 0;
            $this->IdMedioEnfriamiento = $plantilla->IdMedioEnfriamiento ?? 7;
        }
    }

    public function render()
    {
        return view('livewire.programacion-create2', [
            'tratamientos' => Tratamiento::all(),
            'usuarios' => User::all(),
            'tipos_programacion' => TipoProgramacion::all(),
            'medios_enfriamiento' => MedioEnfriamiento::all(),
        ]);
    }
}
