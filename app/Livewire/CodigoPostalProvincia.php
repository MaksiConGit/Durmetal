<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class CodigoPostalProvincia extends Component
{
    public $cities;
    public $cp = '';
    public $provinceName = '';

    public $emitTo = 'localidad'; // nombre del componente al que se emitirá el evento

    public function seleccionarCp($value)
    {
        $this->cp = $value;
        $city = City::with('province')->where('cp', $value)->first();

        if ($city) {
            $this->provinceName = $city->province->name;
            $this->dispatch('actualizarLocalidad', $city->name, $city->id)->to($this->emitTo);
        } else {
            $this->provinceName = '';
            $this->dispatch('actualizarLocalidad', '', null)->to($this->emitTo);
        }
    }

    public function mount()
    {
        $this->cities = City::all();

        if (old('cp')) {
            $this->seleccionarCp(old('cp'));
        }
    }

    public function render()
    {
        return view('livewire.codigo-postal-provincia');
    }
}
