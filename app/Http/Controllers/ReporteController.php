<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTratamientoRequest;
use App\Models\Client;
use App\Models\ItemOrdenTrabajo;
use App\Models\Material;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function materiales()
    {
        return view('produccion.reportes.materiales.index');
    }

    public function materialesResumido()
    {
        return view('produccion.reportes.materiales-resumido.index');
    }

    public function materialesResumidoExcel()
    {
        return view('produccion.reportes.materiales-resumido-excel.index');
    }

}
