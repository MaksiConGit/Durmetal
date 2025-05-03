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
                  ->orWhere('name', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%')
                  ->orWhere('document_number', 'like', '%' . $this->search . '%')
                  
                  // Buscar en ciudad
                  ->orWhereHas('city', function ($q) {
                      $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('province', function ($q2) {
                            $q2->where('name', 'like', '%' . $this->search . '%');
                        });
                  })
    
                  // Buscar en condición IVA
                  ->orWhereHas('ivaCondition', function ($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  })
    
                  // Buscar en tipo de documento
                  ->orWhereHas('documentType', function ($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
        })->get();
    
        return view('livewire.barra-busqueda', compact('clients'));
    }
    
}
