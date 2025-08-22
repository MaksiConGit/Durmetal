<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReglaRequest;
use App\Models\Regla;
use Illuminate\Http\Request;

class ReglaController extends Controller
{
    public function index()
    {
        $reglas = Regla::all();

        return view('sistema.configuracion.reglas.index', compact('reglas'));
    }

    public function create()
    {
        return view('sistema.configuracion.reglas.create');
    }

    public function store(StoreReglaRequest $request)
    {
        $data = $request->all();

        Regla::create($data);
    
        return redirect()->route('sistema.configuracion.reglas.index');
    }

    public function edit(Regla $regla)
    {
        return view('sistema.configuracion.reglas.edit', compact('regla'));
    }

    public function update(StoreReglaRequest $request, Regla $regla)
    {
        $data = $request->all();

        $regla->update($data);
    
        return redirect()->route('sistema.configuracion.reglas.index');
    }

    public function destroy(Regla $regla)
    {
        $regla->delete();
    
        return redirect()->route('sistema.configuracion.reglas.index');
    }
}
