<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePremioRequest;
use App\Models\ItemPremio;
use App\Models\Premio;
use App\Models\Programacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngresoDatosController extends Controller
{
    public function index()
    {
        return view('produccion.ingreso-datos.index');
    }

    public function update(Request $request, Programacion $programacion)
    {
        $data = $request->all();

        $accion = $request->input('accion');

        if ($accion === 'aprobar') {
            foreach ($data['ProgramacionIds'] as $IdProgramacion) {

                $programacion = Programacion::find($IdProgramacion);

                if ($programacion) {

                    $programacion->update([
                        'DurezaMinima' => $data['DurezaMinima'][$IdProgramacion] ?? 0,
                        'DurezaMaxima' => $data['DurezaMaxima'][$IdProgramacion] ?? 0,
                        'Apto' => $data['ProcesoApto'][$IdProgramacion] ?? null,
                    ]);
                }

                $programacion->itemOrdenTrabajo->update([
                    'Estado' => 'APROBADO'
                ]);

            }

        }
        elseif ($accion === 'aceptar') {

            foreach ($data['ProgramacionIds'] as $IdProgramacion) {

                $programacion = Programacion::find($IdProgramacion);

                if ($programacion) {

                    $programacion->update([
                        'DurezaMinima' => $data['DurezaMinima'][$IdProgramacion] ?? 0,
                        'DurezaMaxima' => $data['DurezaMaxima'][$IdProgramacion] ?? 0,
                        'Apto' => $data['ProcesoApto'][$IdProgramacion] ?? null,
                    ]);
                }
                
            }

        }
    
        return redirect()->route('ingreso-datos.index');
    }
}
