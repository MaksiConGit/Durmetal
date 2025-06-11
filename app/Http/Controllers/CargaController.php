<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramacionRequest;
use App\Models\Carga;
use App\Models\MedioEnfriamiento;
use App\Models\Programacion;
use App\Models\TipoProgramacion;
use App\Models\Tratamiento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CargaController extends Controller
{
    public function index()
    {
        $cargas = Carga::all();

        return view('produccion.cargas.index', compact('cargas'));
    }

    public function show($ids)
    {
        $idsArray = explode(',', $ids);

        $programaciones = Programacion::whereIn('id', $idsArray)
            ->with(['medioEnfriamiento', 'ejecutadoPorOperador'])
            ->get();

        return view('produccion.cargas.show', compact('programaciones'));
    }

    public function edit($ids)
    {
        $idsArray = explode(',', $ids);

        $programaciones = Programacion::whereIn('id', $idsArray)
            ->with(['medioEnfriamiento', 'ejecutadoPorOperador'])
            ->get();

        $primer_programacion = $programaciones->first();

        $tratamientos = Tratamiento::all();
        $usuarios = User::all();
        $tipos_programacion = TipoProgramacion::all();
        $medios_enfriamiento = MedioEnfriamiento::all();

        return view('produccion.cargas.edit', compact('programaciones', 'tratamientos', 'usuarios', 'tipos_programacion', 'medios_enfriamiento', 'primer_programacion', 'idsArray'));
    }
    
    public function update(StoreProgramacionRequest $request)
    {
        $user_id = Auth::id();
        $data = $request->all();

        foreach ($request->programaciones as $programacion_id) {
            if ($programacion_id) {
                $programacion = Programacion::find($programacion_id);

                if ($programacion) {
                    $programacion->update([
                        'IdTipoProgramacion' => $data['IdTipoProgramacion'],
                        'FechaCarga' => $data['FechaCarga'],
                        'FechaDescarga' => $data['FechaDescarga'],
                        'EjecutadoPorOperador' => $data['EjecutadoPorOperador'],
                        'NumeroHorno' => $data['NumeroHorno'],
                        'Temperatura' => $data['Temperatura'],
                        'IdMedioEnfriamiento' => $data['IdMedioEnfriamiento'],
                        'ActualizadoPor' => $user_id,
                        'FechaActualizacion' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('index');
    }

    
}
