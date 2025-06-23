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
        
        // dd($data);

        foreach ($data['ProgramacionIds'] as $IdProgramacion) {

            $programacion = Programacion::find($IdProgramacion);

            if ($programacion) {

                $programacion->update([
                    'DurezaMinima' => $data['DurezaMinima'][$IdProgramacion],
                    'DurezaMaxima' => $data['DurezaMaxima'][$IdProgramacion],
                    'Apto' => $data['ProcesoApto'][$IdProgramacion] ?? null,
                ]);
            }
            

        }
    
        return redirect()->route('ingreso-datos.index');
    }
}
