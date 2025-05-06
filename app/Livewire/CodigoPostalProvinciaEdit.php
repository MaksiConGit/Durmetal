<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class CodigoPostalProvinciaEdit extends Component
{
    public $cities;
    public $CP = '';
    public $provinceName = '';
    public $initialCityId = null;

    public $emitTo = 'localidad-edit';

    public function mount($initialCityId = null)
    {
        $this->cities = City::all();
        $this->initialCityId = $initialCityId;

        if ($initialCityId) {
            $city = City::find($initialCityId)->first();
            // $city = City::with('provincia')->find($initialCityId);
            if ($city) {
                $this->CP = $city->CP;
                $this->provinceName = $city->provincia->Nombre;
                $this->dispatch('actualizarLocalidad', $city->Nombre, $city->id)->to($this->emitTo);
            }
        }
    }

    public function seleccionarCp($value)
    {
        $this->CP = $value;
        $city = City::where('CP', $value)->first();

        if ($city) {
            // dd($city);
            $this->provinceName = $city->provincia->Nombre;
            $this->dispatch('actualizarLocalidad', $city->Nombre, $city->id)->to($this->emitTo);
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
