<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ConfiguracionGlobal;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function trabajosSinFacturar()
    {
        $clientes = Client::all();
        $items_orden_trabajo = ItemOrdenTrabajo::whereIn('Estado', ['PENDIENTE'])->get();

        return view('ventas.trabajos-sin-facturar.index', compact('clientes', 'items_orden_trabajo'));
    }

    public function listadoDeRetenciones()
    {
        $clientes = Client::limit(20)->get();

        return view('ventas.listado-de-retenciones.index', compact('clientes'));
    }
    
    public function listadoDePrecios()
    {
        $tratamientos = Tratamiento::all();
        $configuracion_global = ConfiguracionGlobal::first();

        return view('ventas.listado-de-precios.index', compact('tratamientos', 'configuracion_global'));
    }
}
