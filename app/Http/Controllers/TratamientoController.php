<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTratamientoRequest;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamiento::all();

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

    public function update(StoreTratamientoRequest $request, Tratamiento $tratamiento)
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
