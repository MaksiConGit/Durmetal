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

    public function pesos()
    {
        return view('produccion.reportes.pesos.index');
    }

    public function pesosResumido()
    {
        return view('produccion.reportes.pesos-resumido.index');
    }

    public function trabajosNoAptos()
    {
        return view('produccion.reportes.trabajos-no-aptos.index');
    }

    public function premios()
    {
        return view('produccion.reportes.premios.index');
    }

    public function premiosPorAprobacion()
    {
        return view('produccion.reportes.premios-por-aprobacion.index');
    }

    public function premiosPorAprobacionUpdate(Request $request)
    {
        $request->validate([
            'ItemOrdenTrabajo_ids' => 'required|array|min:1',
            'FechaActualizacionEstado' => 'required|date',
        ]);

        $data = $request->all();

        foreach ($data['ItemOrdenTrabajo_ids'] as $item_orden_trabajo_id) {

            $item_orden_trabajo = ItemOrdenTrabajo::find($item_orden_trabajo_id);

            if ($item_orden_trabajo) {
                $item_orden_trabajo->update([
                    'FechaActualizacionEstado' => $data['FechaActualizacionEstado'],
                ]);
            }
        }
    
        return redirect()->route('reportes.premios-por-aprobacion')->with('success', 'Fechas actualizadas');
    }

}
