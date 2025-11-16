<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCodigoComplejidadRequest;
use App\Http\Requests\StoreTratamientoRequest;
use App\Http\Requests\UpdateCodigoComplejidadRequest;
use App\Http\Requests\UpdateTratamientoRequest;
use App\Models\CodigoComplejidad;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodigoComplejidadController extends Controller
{
    public function index()
    {
        return view('ventas.actualizaciones.precios.index');
    }

    public function create(Tratamiento $tratamiento)
    {
        if (!session('modal')) {
            session()->put('modal', 'create');
        }
        
        return view('ventas.actualizaciones.precios.create', compact('tratamiento'));
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

        return redirect()->route('ventas.precios.create', compact('tratamiento'));
    }

    public function update(UpdateCodigoComplejidadRequest $request, CodigoComplejidad $precio)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $precio = CodigoComplejidad::find($data['IdCodigoComplejidad']);
        
        $precio->update($data);

        $tratamiento = Tratamiento::find($data['IdTratamiento']);
    
        return redirect()->route('ventas.precios.create', compact('tratamiento'));
    }

    public function updateTratamiento(UpdateTratamientoRequest $request, Tratamiento $tratamiento)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $tratamiento->update($data);

        session()->put('tratamiento_id', $tratamiento->id);
    
        return redirect()->route('ventas.precios.index', compact('tratamiento'));
    }

    public function updatePrecio(Request $request, CodigoComplejidad $precio)
    {
        session()->put('modal', 'other');

        if (!$request->has('items') || empty($request->items)) {
            return redirect()->back()
                ->withErrors(['items' => 'Debe seleccionar al menos un ítem para actualizar el precio.'])
                ->withInput();
        }

        $data = $request->all();

        foreach ($request->items as $index => $itemData) {

            $codigo_complejidad = CodigoComplejidad::find($itemData['IdCodigoComplejidad']);
            
            $codigo_complejidad->update([
                'Precio' => $itemData['Precio'],
                'Coeficiente' => $itemData['Coeficiente'],
                'FechaActualizacion' => now(),
                'FechaActualizacion' => now(),
                'ActualizadoPor' => Auth::id(),
            ]);
        }

        $tratamiento = Tratamiento::find($data['IdTratamiento']);
    
        return redirect()->route('ventas.precios.create', compact('tratamiento'));
    }

    public function destroy(Tratamiento $tratamiento, CodigoComplejidad $precio)
    {
        $precio->delete();
        return redirect()->route('tratamientos.edit', $tratamiento);
    }


}
