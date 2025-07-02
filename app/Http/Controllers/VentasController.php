<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ItemOrdenTrabajo;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function trabajosSinFacturar()
    {
        $clientes = Client::all();
        $items_orden_trabajo = ItemOrdenTrabajo::whereIn('Estado', ['PENDIENTE'])->get();

        return view('ventas.trabajos-sin-facturar.index', compact('clientes', 'items_orden_trabajo'));
    }
}
