<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlantillaEmailRequest;
use App\Models\PlantillaEmail;
use Illuminate\Http\Request;

class PlantillaEmailController extends Controller
{
    public function index()
    {
        $plantillas_email = PlantillaEmail::all();

        return view('sistema.configuracion.plantillas-de-email.index', compact('plantillas_email'));
    }

    public function create()
    {
        return view('sistema.configuracion.plantillas-de-email.create');
    }

    public function store(StorePlantillaEmailRequest $request)
    {
        $data = $request->all();

        PlantillaEmail::create($data);
    
        return redirect()->route('sistema.configuracion.plantillas-de-email.index');
    }

    public function edit(PlantillaEmail $plantilla_email)
    {
        return view('sistema.configuracion.plantillas-de-email.edit', compact('plantilla_email'));
    }

    public function update(StorePlantillaEmailRequest $request, PlantillaEmail $plantilla_email)
    {
        $data = $request->all();

        $plantilla_email->update($data);
    
        return redirect()->route('sistema.configuracion.plantillas-de-email.index');
    }

    public function destroy(PlantillaEmail $plantilla_email)
    {
        $plantilla_email->delete();
    
        return redirect()->route('sistema.configuracion.plantillas-de-email.index');
    }
}
