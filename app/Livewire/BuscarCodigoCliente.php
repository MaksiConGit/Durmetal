<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;

class BuscarCodigoCliente extends Component
{
    public $cliente_id;

    public function render()
    {
        return view('livewire.buscar-codigo-cliente', [
            'clientes' => Client::all(),
        ]);
    }
}
