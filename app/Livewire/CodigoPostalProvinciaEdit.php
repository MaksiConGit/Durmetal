<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class CodigoPostalProvinciaEdit extends Component
{
    public $cities;
    public $cp = '';
    public $provinceName = '';
    public $initialCityId = null;

    public $emitTo = 'localidad-edit';

    public function mount($initialCityId = null)
    {
        $this->cities = City::all();
        $this->initialCityId = $initialCityId;

        if ($initialCityId) {
            $city = City::with('province')->find($initialCityId);
            if ($city) {
                $this->cp = $city->cp;
                $this->provinceName = $city->province->name;
                $this->dispatch('actualizarLocalidad', $city->name, $city->id)->to($this->emitTo);
            }
        }
    }

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

    public function render()
    {
        return view('livewire.codigo-postal-provincia-edit');
    }
}
