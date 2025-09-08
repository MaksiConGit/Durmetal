<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedioEnfriamientoRequest;
use App\Http\Requests\UpdateMedioEnfriamientoRequest;
use App\Models\Client;
use App\Models\MedioEnfriamiento;
use Illuminate\Http\Request;

class MedioEnfriamientoController extends Controller
{
    public function index()
    {
        $medios_enfriamiento = MedioEnfriamiento::all();

        if (!session('modal')) {
            session()->put('modal', 'create');
        }

        return view('produccion.actualizaciones.medios-enfriamiento.index', compact('medios_enfriamiento'));
    }

    public function create()
    {
        return view('produccion.actualizaciones.medios-enfriamiento.create');
    }

    public function store(StoreMedioEnfriamientoRequest $request)
    {
        $data = $request->all();

        $data['Orden'] = 0;

        $medio_enfriamiento = MedioEnfriamiento::create($data);
    
        return redirect()->route('medios-enfriamiento.index');
    }

    public function edit(MedioEnfriamiento $medio_enfriamiento)
    {
        return view('produccion.actualizaciones.medios-enfriamiento.edit', compact('medio_enfriamiento'));
    }

    public function update(UpdateMedioEnfriamientoRequest $request, MedioEnfriamiento $medio_enfriamiento)
    {
        $data = $request->all();

        $medio_enfriamiento->update($data);
    
        return redirect()->route('medios-enfriamiento.index');
    }

    public function destroy(MedioEnfriamiento $medio_enfriamiento)
    {
        $medio_enfriamiento->delete();
    
        return redirect()->route('medios-enfriamiento.index');
    }

}
