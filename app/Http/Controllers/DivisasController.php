<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUSDARSRequest;
use App\Models\ConfiguracionGlobal;
use Illuminate\Http\Request;

class DivisasController extends Controller
{
    public function edit()
    {
        $configuracion_global = ConfiguracionGlobal::first();

        return view('ventas.actualizaciones.divisas.edit', compact('configuracion_global'));
    }

    public function update(StoreUSDARSRequest $request, ConfiguracionGlobal $configuracion_global)
    {
        $data = $request->all();

        $data['FechaActualizacionUSD_ARS'] = now();

        $configuracion_global->update($data);

        return back();
    }
}
