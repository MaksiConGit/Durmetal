<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

class ProgramacionController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamiento::all();
        $clientes = Client::all();
        $items_orden_trabajo = ItemOrdenTrabajo::all();

        return view('produccion.programacion.index', compact('tratamientos', 'clientes', 'items_orden_trabajo'));
    }
    
    public function create(Request $request)
    {
        // Obtenemos los IDs desde la query string
        $selectedItemIds = explode(',', $request->query('items'));

        // Ahora podés usar los IDs para buscar los items, por ejemplo:
        $items = ItemOrdenTrabajo::whereIn('id', $selectedItemIds)->get();

        return view('produccion.programacion.create', compact('items', 'selectedItemIds'));
    }
}
