<?php

namespace App\Livewire;

use App\Models\Proveedor;
use Livewire\Component;
use Illuminate\Database\QueryException;

class BarraBusquedaProveedor extends Component
{
    public $search = '';
    public $selectedId = null;

    public function selectClient($id)
    {
        $this->selectedId = $id;
    }

    public function eliminarProveedor($id)
    {
        if (!$id) return;

        try {

            $proveedor = Proveedor::find($id);

            if ($proveedor) {
                $proveedor->delete();
            }

            session()->flash('success', 'Proveedor eliminado correctamente.');

        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1451) {

                session()->flash(
                    'error',
                    'No se puede eliminar el proveedor porque tiene registros asociados (facturas, compras u otros movimientos).'
                );

            } else {
                throw $e;
            }
        }
    }

    public function render()
    {
        $proveedores = Proveedor::where(function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                  ->orWhere('Nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('Direccion', 'like', '%' . $this->search . '%')
                  ->orWhere('Telefono', 'like', '%' . $this->search . '%')
                  ->orWhere('NumeroDocumento', 'like', '%' . $this->search . '%')
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

        return view('livewire.barra-busqueda-proveedor', compact('proveedores'));
    }
}
