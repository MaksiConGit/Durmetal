<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversorDurezaRequest;
use App\Models\ConversorDureza;
use Illuminate\Http\Request;

class ConversorDurezasController extends Controller
{
    public function index()
    {
        $conversiones_durezas = ConversorDureza::all();

        return view('sistema.configuracion.conversor-de-durezas.index', compact('conversiones_durezas'));
    }

    public function create()
    {
        return view('sistema.configuracion.conversor-de-durezas.create');
    }

    public function store(StoreConversorDurezaRequest $request)
    {
        $data = $request->all();

        ConversorDureza::create($data);
    
        return redirect()->route('sistema.configuracion.conversor-de-durezas.index');
    }

    public function edit(ConversorDureza $conversor_dureza)
    {
        return view('sistema.configuracion.conversor-de-durezas.edit', compact('conversor_dureza'));
    }

    public function update(StoreConversorDurezaRequest $request, ConversorDureza $conversor_dureza)
    {
        $data = $request->all();

        $conversor_dureza->update($data);
    
        return redirect()->route('sistema.configuracion.conversor-de-durezas.index');
    }

    public function destroy(ConversorDureza $conversor_dureza)
    {
        $conversor_dureza->delete();
    
        return redirect()->route('sistema.configuracion.conversor-de-durezas.index');
    }
}
