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

}
