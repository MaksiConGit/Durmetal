<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class CodigoPostalLocalidadProvinciaEdit extends Component
{
    public $cp = '';
    public $cityName = '';
    public $provinceName = '';
    public $cityId = null;
    public $client;

    public $next_id;
    public $condiciones_IVA;
    public $calificaciones_cliente;

    public function mount($next_id = null, $condiciones_IVA = [], $calificaciones_cliente = [], $client = null)
    {
        $this->next_id = $next_id;
        $this->condiciones_IVA = $condiciones_IVA;
        $this->calificaciones_cliente = $calificaciones_cliente;
        $this->client = $client;

        if ($client) {
            $this->cp = $client->localidad->CP;
            $this->cityId = $client->IdLocalidad;
            $city = City::find($client->IdLocalidad);
            if ($city) {
                $this->cityName = $city->Nombre;
                $this->provinceName = $city->provincia->Nombre;
            }
        }
    }

    public function updatedCp($value)
    {
        $city = City::where('CP', $value)->first();

        if ($city) {
            $this->cityName = $city->Nombre;
            $this->cityId = $city->id;
            $this->provinceName = $city->provincia->Nombre;
        } else {
            $this->cityName = '';
            $this->cityId = null;
            $this->provinceName = '';
        }
    }

    public function render()
    {
        return view('livewire.codigo-postal-localidad-provincia-edit');
    }
}
