<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoProgramacionRequest;
use App\Http\Requests\UpdateTipoProgramacionRequest;
use App\Models\TipoProgramacion;
use Illuminate\Http\Request;

class ProcesoController extends Controller
{
    public function index()
    {
        $procesos = TipoProgramacion::all();

        if (!session('modal')) {
            session()->put('modal', 'create');
        }

        return view('produccion.actualizaciones.procesos.index', compact('procesos'));
    }

    public function create()
    {
        return view('produccion.actualizaciones.procesos.create');
    }

    public function store(StoreTipoProgramacionRequest $request)
    {
        $data = $request->all();

        $data['Orden'] = 0;
        $data['NombreTipo'] = $data['Nombre'] . ',' . $data['Tipo'];

        $proceso = TipoProgramacion::create($data);
    
        return redirect()->route('procesos.index');
    }

    public function edit(TipoProgramacion $proceso)
    {
        return view('produccion.actualizaciones.procesos.edit', compact('proceso'));
    }

    public function update(UpdateTipoProgramacionRequest $request, TipoProgramacion $proceso)
    {
        $data = $request->all();

        $proceso->update($data);
    
        return redirect()->route('procesos.index');
    }

    public function destroy(TipoProgramacion $proceso)
    {
        $proceso->delete();
    
        return redirect()->route('procesos.index');
    }

}
