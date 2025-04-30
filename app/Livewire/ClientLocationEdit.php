<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class ClientLocationEdit extends Component
{
    public $client;
    public $cities;
    public $cp = '';
    public $cityName = '';
    public $provinceName = '';
    public $city_id = '';

    public function seleccionarCp($value)
    {
        $city = City::with('province')->where('cp', $value)->first();
    
        if ($city) {
            $this->cityName = $city->name;
            $this->provinceName = $city->province->name;
            $this->city_id = $city->id;
        } else {
            $this->cityName = '';
            $this->provinceName = '';
            $this->city_id = '';
        }
    }

    public function mount($client)
    {
        $this->cities = City::with('province')->get();
        $this->client = $client;
    
        if ($client->city) {
            $this->cp = $client->city->cp;
            $this->cityName = $client->city->name;
            $this->provinceName = $client->city->province->name ?? '';
            $this->city_id = $client->city->id;
        }
    }  

    public function render()
    {
        return view('livewire.client-location-edit');
    }
}
