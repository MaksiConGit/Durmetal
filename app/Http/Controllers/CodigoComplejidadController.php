<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCodigoComplejidadRequest;
use App\Models\CodigoComplejidad;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodigoComplejidadController extends Controller
{
    public function index()
    {
        $precios = CodigoComplejidad::all();

        return view('produccion.actualizaciones.precios.index', compact('precios'));
    }

    public function create(Tratamiento $tratamiento)
    {
        $next_codigo = CodigoComplejidad::max('CC') + 1;

        return view('produccion.actualizaciones.precios.create', compact('next_codigo', 'tratamiento'));
    }

    public function store(StoreCodigoComplejidadRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;
        $data['IdTratamientoCodigoComplejidad'] = $data['IdTratamiento'] . ',' . $data['CC'];
    
        $precio = CodigoComplejidad::create($data);

        $tratamiento = Tratamiento::find($data['IdTratamiento']);

        return redirect()->route('tratamientos.edit', compact('tratamiento'));
    }

    public function edit(CodigoComplejidad $precio)
    {
        return view('produccion.actualizaciones.precios.edit', compact('precio'));
    }

    public function update(StoreCodigoComplejidadRequest $request, CodigoComplejidad $precio)
    {
        $data = $request->all();

        $precio->update($data);
    
        return redirect()->route('tratamientos.index');
    }

    public function destroy(Tratamiento $tratamiento, CodigoComplejidad $precio)
    {
        $precio->delete();
        return redirect()->route('tratamientos.edit', $tratamiento);
    }


}
