<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class CodigoPostalProvincia extends Component
{
    public $cities;
    public $cp = '';
    public $provinceName = '';

    public $emitTo = 'localidad';

    public function seleccionarCp($value)
    {
        $this->cp = $value;
        $city = City::where('CP', $value)->first();
    
        if ($city) {
            $this->provinceName = $city->provincia->Nombre;
            $this->dispatch('actualizarLocalidad', $city->Nombre, $city->id)->to($this->emitTo);
        } else {
            $this->provinceName = '';
            $this->dispatch('actualizarLocalidad', '', null)->to($this->emitTo);
        }
    }

    public function mount()
    {
        $this->cities = City::all();

        if (old('CP')) {
            $this->seleccionarCp(old('CP'));
        }
    }

    public function render()
    {
        return view('livewire.codigo-postal-provincia');
    }
}
