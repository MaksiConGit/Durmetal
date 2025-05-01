<?php

namespace App\Livewire;

use Livewire\Component;

class Localidad extends Component
{
    public $cityName = '';
    public $cityId = null;

    protected $listeners = ['actualizarLocalidad'];

    public function actualizarLocalidad($cityName, $cityId)
    {
        $this->cityName = $cityName;
        $this->cityId = $cityId;
    }

    public function render()
    {
        return view('livewire.localidad');
    }
}
