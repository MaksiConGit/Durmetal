<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class ClientLocation extends Component
{
    public $cities;
    public $cp = '';
    public $cityName = '';
    public $provinceName = '';

    public function seleccionarCp($value)
    {
        $city = City::with('province')->where('cp', $value)->first();

        if ($city) {
            $this->cityName = $city->name;
            $this->provinceName = $city->province->name;
        } else {
            $this->cityName = '';
            $this->provinceName = '';
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
        return view('livewire.client-location');
    }
}
