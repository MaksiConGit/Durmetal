<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTratamientoRequest;
use App\Http\Requests\UpdateTratamientoRequest;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamiento::all();

        if (!session('modal')) {
            session()->put('modal', 'create');
        }

        return view('produccion.actualizaciones.tratamientos.index', compact('tratamientos'));
    }

    public function create()
    {
        return view('produccion.actualizaciones.tratamientos.create');
    }

    public function store(StoreTratamientoRequest $request)
    {
        $data = $request->all();

        $data['Coeficiente'] = 0;
        $data['Orden'] = 0;
        $data['Archivado'] = 0;

        $tratamiento = Tratamiento::create($data);

        return redirect()->route('tratamientos.index');
    }

    public function edit(Tratamiento $tratamiento)
    {
        $precios = $tratamiento->precios;
        
        return view('produccion.actualizaciones.tratamientos.edit', compact('tratamiento', 'precios'));
    }

    public function update(UpdateTratamientoRequest $request, Tratamiento $tratamiento)
    {
        $data = $request->all();

        $tratamiento->update($data);
    
        return redirect()->route('tratamientos.index');
    }

    public function destroy(Tratamiento $tratamiento)
    {
        $tratamiento->delete();
    
        return redirect()->route('tratamientos.index');
    }

}
