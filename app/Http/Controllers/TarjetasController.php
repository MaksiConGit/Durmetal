<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTarjetaRequest;
use App\Models\Tarjeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TarjetasController extends Controller
{
    public function index()
    {
        $tarjetas = Tarjeta::all();

        return view('sistema.actualizaciones.tarjetas.index', compact('tarjetas'));
    }

    public function create()
    {
        return view('sistema.actualizaciones.tarjetas.create');
    }

    public function store(StoreTarjetaRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;
        $data['Archivado'] = 0;

        Tarjeta::create($data);
    
        return redirect()->route('sistema.actualizaciones.tarjetas.index');
    }

    public function edit(Tarjeta $tarjeta)
    {
        return view('sistema.actualizaciones.tarjetas.edit', compact('tarjeta'));
    }

    public function update(StoreTarjetaRequest $request, Tarjeta $tarjeta)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $tarjeta->update($data);
    
        return redirect()->route('sistema.actualizaciones.tarjetas.index');
    }

    public function destroy(Tarjeta $tarjeta)
    {
        $tarjeta->delete();
    
        return redirect()->route('sistema.actualizaciones.tarjetas.index');
    }
}
