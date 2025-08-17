<?php

namespace App\Livewire;

use App\Models\Proveedor;
use Livewire\Component;

class BarraBusquedaProveedor extends Component
{
    public $search = '';

    public function render()
    {
        $proveedores = Proveedor::where(function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                  ->orWhere('Nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('Direccion', 'like', '%' . $this->search . '%')
                  ->orWhere('Telefono', 'like', '%' . $this->search . '%')
                  ->orWhere('NumeroDocumento', 'like', '%' . $this->search . '%')
                  
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
                  })

                  // Buscar en retencion IIBB
                  ->orWhereHas('retencionIIBB', function ($q) {
                      $q->where('Nombre', 'like', '%' . $this->search . '%');
                  });

        })->get();
    
        return view('livewire.barra-busqueda-proveedor', compact('proveedores'));
    }
    
}
