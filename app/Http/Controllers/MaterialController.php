<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTratamientoRequest;
use App\Models\Client;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materiales = Material::all();

        return view('produccion.actualizaciones.materiales.index', compact('materiales'));
    }

    public function create()
    {
        return view('produccion.actualizaciones.materiales.create');
    }

    public function store(StoreTratamientoRequest $request)
    {
        $data = $request->all();

        $material = Material::create($data);
    
        return redirect()->route('materiales.index');
    }

    public function edit(Material $material)
    {
        return view('produccion.actualizaciones.materiales.edit', compact('material'));
    }

    public function update(StoreTratamientoRequest $request, Material $material)
    {
        $data = $request->all();

        $material->update($data);
    
        return redirect()->route('materiales.index');
    }

    public function destroy(Material $material)
    {
        $material->delete();
    
        return redirect()->route('materiales.index');
    }

}
