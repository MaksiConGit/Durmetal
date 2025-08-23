<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

class FichaDelCliente extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $dureza_min;
    public $dureza_max;
    public $materiales_seleccionados = [];
    public $cliente_id = null;
    public $filtro = null;

    public function render()
    {
        $query = Client::query();

        if (!empty($this->cliente_id)) {
            $query->where('id', $this->cliente_id);
        }

        if ($this->filtro === 'notas_pendientes') {
            $query->whereHas('notasDeEnvio', function ($q) {
                $q->where('Estado', 'PENDIENTE');
            });
        }

        if ($this->filtro === 'facturas_pendientes') {
            $query->whereHas('facturasVenta', function ($q) {
                $q->where('Estado', 'PENDIENTE');
            });
        }

        if ($this->filtro === 'trabajos_pendientes_nota_envio') {
            $query->whereHas('ordenesTrabajo', function ($q) {
                $q->where('Estado', 'PENDIENTE')
                  ->whereHas('itemsOrdenTrabajo', function ($qi) {
                      $qi->where('Estado', 'APROBADO')
                         ->where('ConNotaEnvio', false);
                  });
            });
        }

        $clientes = $query->withCount([
            'notasDeEnvio as notas_envio_pendientes_count' => function ($q) {
                $q->where('Estado', 'PENDIENTE');
            },

            'facturasVenta as facturas_pendientes_count' => function ($q) {
                $q->where('Estado', 'PENDIENTE');
            },
        ])
        ->with(['ordenesTrabajo' => function($q) {
            $q->where('Estado', 'PENDIENTE')
            ->withCount(['itemsOrdenTrabajo as items_pendientes_count' => function ($qi) {
                $qi->where('Estado', 'APROBADO')
                    ->where('ConNotaEnvio', false);
            }]);
        }])
        ->get();

        foreach ($clientes as $cliente) {
            $cliente->ordenes_trabajo_pendientes_count = $cliente->ordenesTrabajo->sum('items_pendientes_count');
        }
        
        return view('livewire.ficha-del-cliente', [
            'clientes' => $clientes,
            'clientes_all' => Client::all()
        ]);
    }
}
