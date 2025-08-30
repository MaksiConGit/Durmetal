<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

class BarraBusqueda2 extends Component
{
    public $search = '';
    public $selectedId = null;

    public function selectClient($id)
    {
        $this->selectedId = $id;
    }

    public function render()
    {
        $clients = Client::where(function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                  ->orWhere('Nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('Domicilio', 'like', '%' . $this->search . '%')
                  ->orWhere('Telefono', 'like', '%' . $this->search . '%')
                  ->orWhere('NroDocumento', 'like', '%' . $this->search . '%')
                  ->orWhere('TipoDocumento', 'like', '%' . $this->search . '%')
                  ->orWhereHas('localidad', function ($q) {
                      $q->where('Nombre', 'like', '%' . $this->search . '%')
                        ->orWhereHas('provincia', function ($q2) {
                            $q2->where('Nombre', 'like', '%' . $this->search . '%');
                        });
                  })
                  ->orWhereHas('condicionIVA', function ($q) {
                      $q->where('Nombre', 'like', '%' . $this->search . '%');
                  });
        })->get();

        return view('livewire.barra-busqueda2', compact('clients'));
    }
}
