<?php

namespace App\Livewire;

use App\Models\Proveedor;
use Livewire\Component;

class FichaDelProveedor2 extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $dureza_min;
    public $dureza_max;
    public $materiales_seleccionados = [];
    public $codigo = '';
    public $nombre = '';
    public $documento = '';
    public $filtro = null;

    public function render()
    {
        $query = Proveedor::query();

        if (!empty($this->codigo)) {
            $query->where('id', 'like', "%{$this->codigo}%");
        }

        if (!empty($this->nombre)) {
            $query->where('Nombre', 'like', "%{$this->nombre}%");
        }

        if (!empty($this->documento)) {
            $query->where('NumeroDocumento', 'like', "%{$this->documento}%");
        }

        return view('livewire.ficha-del-proveedor2', [
            'proveedores' => $query->orderBy('Nombre', 'asc')->get()
        ]);
    }
}
