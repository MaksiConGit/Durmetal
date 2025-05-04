<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

class BarraBusqueda extends Component
{
    public $search = '';

    public function render()
    {
        $clients = Client::where(function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                  ->orWhere('Nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('Domicilio', 'like', '%' . $this->search . '%')
                  ->orWhere('Telefono', 'like', '%' . $this->search . '%')
                  ->orWhere('NroDocumento', 'like', '%' . $this->search . '%')
                  ->orWhere('TipoDocumento', 'like', '%' . $this->search . '%')
                  
                  // Buscar en ciudad
                  ->orWhereHas('localidad', function ($q) {
                      $q->where('Nombre', 'like', '%' . $this->search . '%')
                        ->orWhereHas('provincia', function ($q2) {
                            $q2->where('Nombre', 'like', '%' . $this->search . '%');
                        });
                  })
    
                  // Buscar en condición IVA
                  ->orWhereHas('condicionIVA', function ($q) {
                      $q->where('Nombre', 'like', '%' . $this->search . '%');
                  });

        })->get();
    
        return view('livewire.barra-busqueda', compact('clients'));
    }
    
}
