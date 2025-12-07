<?php

namespace App\Livewire;

use App\Models\NotaEnvio;
use App\Models\PuntoDeVenta;
use App\Models\CodigoComplejidad;
use App\Models\CondicionVenta;
use App\Models\FacturaVenta;
use App\Models\ImpuestoIva;
use App\Models\NotaCreditoVenta;
use Carbon\Carbon;
use Livewire\Component;

class NotaDebitoCreate extends Component
{
    public $notas_envio;
    public $next_nota_credito_numero;
    public $cliente;
    public $factura_venta;
    public $pto_ventas;
    public $condiciones_venta;
    public $fechaEmision;
    public $fechaVencimiento;
    public $descripcion = [];
    public $total = [];
    public $IVA = [];
    public $seleccionados = [];
    public $subtotal = 0;
    public $iva = 0;
    public $total_final = 0;
    public $condicionesSeleccionadas = [];
    public $selectedIdItem = null;
    public $newItems = [];
    public $tempId = -1;
    public $ajuste;
    public $item_id = null;
    public $impuestos_iva;

    public function mount()
    {
        $this->fechaEmision = Carbon::today()->format('Y-m-d');
        $this->fechaVencimiento = Carbon::today()->addDays(7)->format('Y-m-d');
        $this->pto_ventas = PuntoDeVenta::all();
        $this->condiciones_venta = CondicionVenta::all();
        $this->impuestos_iva = ImpuestoIva::orderBy('Nombre', 'ASC')->get();

        $this->condicionesSeleccionadas = 
            collect($this->condiciones_venta)
                ->where('Seleccionado', 1)
                ->pluck('Nombre')
                ->toArray();

        $this->ordenarCondiciones();

        $this->next_nota_credito_numero = NotaCreditoVenta::max('Numero') + 1;
    }

    public function updatedCondicionesSeleccionadas()
    {
        $this->ordenarCondiciones();
    }

    public function ordenarCondiciones()
    {
        $ordenOriginal = collect($this->condiciones_venta)->pluck('Nombre')->toArray();

        usort($this->condicionesSeleccionadas, function ($a, $b) use ($ordenOriginal) {
            return array_search($a, $ordenOriginal) <=> array_search($b, $ordenOriginal);
        });
    }


    public function seleccionarItem($id)
    {
        if ($id) {
            $this->item_id = $id;
        }
    }

    public function borrarItem()
    {
        if ($this->item_id === null) {
            return;
        }

        unset($this->newItems[$this->item_id]);

        $this->newItems = collect($this->newItems)->toArray();

        $this->item_id = null;

        $this->updatedNewItems();
    }


    public function addNewItem()
    {
        $newItemId = $this->tempId;

        $this->newItems[$newItemId] = [
            'Descripcion' => 'DEBITO',
            'Total' => $this->factura_venta->Total,
        ];

        $this->selectedIdItem = $newItemId;

        $this->tempId--;
    }

    public function updatedNewItems()
    {
        $this->subtotal = 0;
        $this->iva = 0;
        $this->total_final = 0;

        foreach ($this->newItems as $item) {

            $sub = floatval($item['Subtotal'] ?? 0);
            $ivaTipo = $item['iva_tipo'] ?? 0;

            if ($ivaTipo === 'exento') {
                $ivaItem = 0;
            }
            elseif ($ivaTipo === 'nogravado') {
                $ivaItem = -($sub * 0.01);
            }
            else {
                $ivaItem = $sub * ((float) $ivaTipo / 100);
            }

            $this->subtotal += $sub;
            $this->iva += $ivaItem;
        }

        $this->total_final = $this->subtotal + $this->iva;
    }

    public function render()
    {
        return view('livewire.nota-debito-create');
    }
}
