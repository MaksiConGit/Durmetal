<?php

namespace App\Livewire;

use App\Models\NotaEnvio;
use App\Models\PuntoDeVenta;
use App\Models\CodigoComplejidad;
use App\Models\CondicionVenta;
use App\Models\FacturaVenta;
use App\Models\NotaCreditoVenta;
use Carbon\Carbon;
use Livewire\Component;

class NotaCreditoCreate extends Component
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

    public function mount()
    {
        $this->fechaEmision = Carbon::today()->format('Y-m-d');
        $this->fechaVencimiento = Carbon::today()->addDays(7)->format('Y-m-d');
        $this->pto_ventas = PuntoDeVenta::all();
        $this->condiciones_venta = CondicionVenta::all();

        // $this->condicionesSeleccionadas = 
        //     collect($this->condiciones_venta)
        //         ->where('Seleccionado', 1)
        //         ->pluck('Nombre')
        //         ->toArray();

        // $this->ordenarCondiciones();

        // $this->notas_envio = NotaEnvio::where('IdCliente', $this->cliente->id)->where('Estado', 'PENDIENTE')->get();

        $this->next_nota_credito_numero = NotaCreditoVenta::max('Numero') + 1;

        // foreach ($this->notas_envio as $item) {
        //     $this->total[$item->id] = $item->Neto;
        //     $this->IVA[$item->id] = $item->Neto * 0.21;
        // }
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

    // Reindexa por seguridad visual (opcional)
    $this->newItems = collect($this->newItems)->toArray();

    // Limpia la selección
    $this->item_id = null;

    // Recalcula totales e IVA automáticamente
    $this->updatedNewItems();
}


    public function addNewItem()
    {
        $newItemId = $this->tempId;

        $this->newItems[$newItemId] = [
            'Descripcion' => 'CREDITO',
            'Total' => $this->factura_venta->Total,
        ];

        $this->selectedIdItem = $newItemId;

        $this->tempId--;
    }

public function updatedNewItems()
{
    $totalFinal = 0;

    foreach ($this->newItems as $item) {
        $totalFinal += round(floatval($item['Total'] ?? 0), 2);
    }

    $subtotal = round($totalFinal / 1.21, 2);
    $iva = round($subtotal * 0.21, 2);

    $reconstruido = round($subtotal + $iva, 2);
    $ajuste = round($totalFinal - $reconstruido, 2);

    $this->subtotal = $subtotal;
    $this->iva = $iva;
    $this->ajuste = $ajuste;
    $this->total_final = $totalFinal;
}



    // public function updatedCondicionesSeleccionadas()
    // {
    //     $this->ordenarCondiciones();
    // }

    // public function ordenarCondiciones()
    // {
    //     $ordenOriginal = collect($this->condiciones_venta)->pluck('Nombre')->toArray();

    //     usort($this->condicionesSeleccionadas, function ($a, $b) use ($ordenOriginal) {
    //         return array_search($a, $ordenOriginal) <=> array_search($b, $ordenOriginal);
    //     });
    // }

    // public function setFechaVencimiento()
    // {
    //     if($this->fechaEmision) {
    //         $this->fechaVencimiento = Carbon::parse($this->fechaEmision)
    //                                         ->addDays(7)
    //                                         ->format('Y-m-d');
    //     } else {
    //         $this->fechaVencimiento = Carbon::today()->addDays(7)->format('Y-m-d');
    //     }
    // }

    // public function updatedSeleccionados($value, $key)
    // {
    //     $id = (int) $key;

    //     $item = $this->notas_envio->firstWhere('id', $id);

    //     if (!$item) return;

    //     if (!empty($this->seleccionados[$id]) && $this->seleccionados[$id]) {
    //         $numeroCompleto = $item->NumeroCompleto;

    //         if (preg_match('/^NE\s+([A-Z])\s+(.+)$/', $numeroCompleto, $matches)) {
    //             $letra = $matches[1];
    //             $numero = $matches[2];
    //         } else {
    //             $numero = '¡¡ERROR!! ¡¡REVISAR!!';
    //         }

    //         $this->descripcion[$id] = "CORRESPONDE A NOTA DE ENVIO {$numero}";
    //     }
    //     else {
    //         $this->descripcion[$id] = $item->Descripcion ?? '';
    //     }

    //     $this->actualizarSubtotal();
    // }

    // public function actualizarSubtotal()
    // {
    //     $this->subtotal = 0;

    //     foreach ($this->notas_envio as $item) {
    //         $id = $item->id;
    //         if (!empty($this->seleccionados[$id]) && $this->seleccionados[$id]) {
    //             $this->subtotal += $this->total[$id] ?? 0;
    //         }
    //     }

    //     $this->actualizarIVATotal();
    // }

    // public function actualizarIVATotal()
    // {
    //     $this->iva = $this->subtotal * 0.21;

    //     $this->total_final = $this->subtotal + $this->iva;
    // }

    // public function updatedTotal()
    // {
    //     $this->actualizarSubtotal();
    // }

    // public function seleccionarTodo()
    // {
    //     foreach ($this->notas_envio as $item) {
    //         $id = $item->id;
    //         $this->seleccionados[$id] = true;
    //         $this->updatedSeleccionados(true, $id);
    //     }

    //     $this->actualizarSubtotal();
    // }

    // public function deseleccionarTodo()
    // {
    //     foreach ($this->notas_envio as $item) {
    //         $id = $item->id;
    //         $this->seleccionados[$id] = false;
    //         $this->updatedSeleccionados(false, $id);
    //     }

    //     $this->actualizarSubtotal();
    // }


    public function render()
    {
        return view('livewire.nota-credito-create');
    }
}
