<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

class FichaDelClienteShow2 extends Component
{
    public $activeTabParametros = 'custom-tabs-1';
    public $cliente;
    public $selectedId = null;
    public $expanded = [];

    public function toggleExpand($id)
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            $this->expanded[] = $id;
        }
        
        $this->selectedId = $id;

    }

    public function mount(Client $cliente)
    {
        $this->cliente = $cliente;
    }

    public function setActiveTabParametros($tabId)
    {
        $this->activeTabParametros = $tabId;
    }

    public function render()
    {
        $ordenes_trabajo   = $this->cliente->ordenesTrabajo;
        $notas_de_envio    = $this->cliente->notasDeEnvio;
        $facturas          = $this->cliente->facturasVenta;
        $recibos           = $this->cliente->recibosVenta;
        $notas_de_credito  = $this->cliente->notasDeCredito;
        $notas_de_debito   = $this->cliente->facturasVenta->where('EsNotaDeDebito', 1);
        $minutas           = $this->cliente->minutas;

        return view('livewire.ficha-del-cliente-show2', [
            'ordenes_trabajo'  => $ordenes_trabajo,
            'notas_de_envio'   => $notas_de_envio,
            'facturas'         => $facturas,
            'recibos'          => $recibos,
            'notas_de_credito' => $notas_de_credito,
            'notas_de_debito'  => $notas_de_debito,
            'minutas'          => $minutas,
        ]);
    }
}
