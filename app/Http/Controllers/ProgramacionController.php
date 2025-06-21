<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramacionRequest;
use App\Models\Carga;
use App\Models\Client;
use App\Models\ItemOrdenTrabajo;
use App\Models\MedioEnfriamiento;
use App\Models\Programacion;
use App\Models\TipoProgramacion;
use App\Models\Tratamiento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramacionController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamiento::all();
        $clientes = Client::all();
        $items_orden_trabajo = ItemOrdenTrabajo::whereIn('Estado', ['PENDIENTE', 'APROBADO'])->get();

        return view('produccion.programacion.index', compact('tratamientos', 'clientes', 'items_orden_trabajo'));
    }
    
    public function create(Request $request)
    {
        $selectedItemIds = explode(',', $request->query('items'));

        $items = ItemOrdenTrabajo::whereIn('id', $selectedItemIds)->get();

        $tratamientos = Tratamiento::all();
        $usuarios = User::all();
        $tipos_programacion = TipoProgramacion::all();
        $medios_enfriamiento = MedioEnfriamiento::all();

        return view('produccion.programacion.create', compact('items', 'selectedItemIds', 'tratamientos', 'usuarios', 'tipos_programacion', 'medios_enfriamiento'));
    }

    public function store(StoreProgramacionRequest $request)
    {
        $user_id = Auth::id();
    
        $data = $request->all();

        // dd($data);

        foreach ($request->ItemOrdenTrabajoIds as $index => $itemOrdenTrabajoId) {
            if ($itemOrdenTrabajoId) {

                $item_orden_trabajo = ItemOrdenTrabajo::find($itemOrdenTrabajoId);

                
                if ($data['NumeroProgramacion'] == 0) {
                    $data['NumeroProgramacion'] = $item_orden_trabajo->programacion->max('NumeroProgramacion') + 1;
                }

                Programacion::create([
                    'IdItemOrdenTrabajo' => $item_orden_trabajo->id,
                    'DurezaMinima' => $item_orden_trabajo->DurezaSolicitadaMinima,
                    'DurezaMaxima' => $item_orden_trabajo->DurezaSolicitadaMaxima,
                    'IdTipoProgramacion' => $data['IdTipoProgramacion'],
                    'Cantidad' => $data['Cantidad'][$index],
                    'Reproceso' => $data['Reproceso'][$index],
                    'FechaCreacion' => now(),
                    'FechaCarga' => $data['FechaCarga'],
                    'FechaDescarga' => $data['FechaDescarga'],
                    'Temperatura' => $data['Temperatura'],
                    'IdMedioEnfriamiento' => $data['IdMedioEnfriamiento'],
                    'NumeroHorno' => $data['NumeroHorno'],
                    'EjecutadoPorOperador' => $data['EjecutadoPorOperador'],
                    'CreadoPor' => $user_id,
                    'ActualizadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'Activo' => '1',
                    'NumeroProgramacion' => $data['NumeroProgramacion'][$index],
                    
                    // 'Apto' => $data[''],

                ]);

            }
        }

        return redirect()->route('index');
    }
    
    public function show(ItemOrdenTrabajo $item_orden_trabajo)
    {
        // dd($item_orden_trabajo);
        $programaciones = Programacion::where('IdItemOrdenTrabajo', $item_orden_trabajo->id)->get();

        return view('produccion.programacion.show', compact('item_orden_trabajo', 'programaciones'));
    }

}
