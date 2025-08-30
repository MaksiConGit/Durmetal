<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

class FichaDelCliente2 extends Component
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
        $query = Client::query();

        if (!empty($this->codigo)) {
            $query->where('id', 'like', "%{$this->codigo}%");
        }

        if (!empty($this->nombre)) {
            $query->where('Nombre', 'like', "%{$this->nombre}%");
        }

        if (!empty($this->documento)) {
            $query->where('NroDocumento', 'like', "%{$this->documento}%");
        }

        if ($this->filtro === 'notas_pendientes') {
            $query->whereHas('notasDeEnvio', fn($q) => $q->where('Estado', 'PENDIENTE'));
        }

        if ($this->filtro === 'facturas_pendientes') {
            $query->whereHas('facturasVenta', fn($q) => $q->where('Estado', 'PENDIENTE'));
        }

        if ($this->filtro === 'trabajos_pendientes_nota_envio') {
            $query->whereHas('ordenesTrabajo', fn($q) => 
                $q->where('Estado', 'PENDIENTE')
                ->whereHas('itemsOrdenTrabajo', fn($qi) =>
                    $qi->where('Estado', 'APROBADO')->where('ConNotaEnvio', false)
                )
            );
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
        
        return view('livewire.ficha-del-cliente2', [
            'clientes' => $clientes,
            'clientes_all' => Client::all()
        ]);
    }
}
