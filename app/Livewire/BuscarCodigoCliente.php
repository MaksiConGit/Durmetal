<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;

class BuscarCodigoCliente extends Component
{
    public $cliente_id;


    public function mount($id_cliente = null)
    {
        if ($id_cliente) {
            $this->cliente_id = $id_cliente;
        }
    }

    public function render()
    {
        return view('livewire.buscar-codigo-cliente', [
            'clientes' => Client::all(),
        ]);
    }
}
