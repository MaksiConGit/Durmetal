<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use App\Models\Programacion;
use Illuminate\Http\Request;

class CargaController extends Controller
{
    public function index()
    {
        $cargas = Carga::all();

        return view('produccion.cargas.index', compact('cargas'));
    }

    public function show($ids)
    {
        // Convertir la cadena "1,5,9" en un array [1,5,9]
        $idsArray = explode(',', $ids);

        // Traer las programaciones por esos IDs
        $programaciones = Programacion::whereIn('id', $idsArray)
            ->with(['medioEnfriamiento', 'ejecutadoPorOperador']) // con relaciones si tenés
            ->get();

        return view('produccion.cargas.show', compact('programaciones'));
    }
}
