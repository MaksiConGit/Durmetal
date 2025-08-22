<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlantillaCargaRequest;
use App\Models\PlantillaCarga;
use Illuminate\Http\Request;

class PlantillaCargaController extends Controller
{
    public function index()
    {
        $plantillas_carga = PlantillaCarga::all();

        return view('sistema.configuracion.plantillas-de-carga.index', compact('plantillas_carga'));
    }

    public function create()
    {
        return view('sistema.configuracion.plantillas-de-carga.create');
    }

    public function store(StorePlantillaCargaRequest $request)
    {
        $data = $request->all();

        PlantillaCarga::create($data);
    
        return redirect()->route('sistema.configuracion.plantillas-de-carga.index');
    }

    public function edit(PlantillaCarga $plantilla_carga)
    {
        return view('sistema.configuracion.plantillas-de-carga.edit', compact('plantilla_carga'));
    }

    public function update(StorePlantillaCargaRequest $request, PlantillaCarga $plantilla_carga)
    {
        $data = $request->all();

        $plantilla_carga->update($data);
    
        return redirect()->route('sistema.configuracion.plantillas-de-carga.index');
    }

    public function destroy(PlantillaCarga $plantilla_carga)
    {
        $plantilla_carga->delete();
    
        return redirect()->route('sistema.configuracion.plantillas-de-carga.index');
    }
}
