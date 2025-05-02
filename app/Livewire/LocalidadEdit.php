<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class LocalidadEdit extends Component
{
    public $cityName = '';
    public $cityId = null;

    protected $listeners = ['actualizarLocalidad'];

    public function mount($initialCityId = null)
    {
        if ($initialCityId) {
            $city = City::find($initialCityId);
            if ($city) {
                $this->cityName = $city->name;
                $this->cityId = $city->id;
            }
        }
    }

    public function actualizarLocalidad($cityName, $cityId)
    {
        $this->cityName = $cityName;
        $this->cityId = $cityId;
    }

    public function render()
    {
        return view('livewire.localidad-edit');
    }
}
