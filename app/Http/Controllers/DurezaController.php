<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDurezaRequest;
use App\Http\Requests\UpdateDurezaRequest;
use App\Models\Client;
use App\Models\Dureza;
use Illuminate\Http\Request;

class DurezaController extends Controller
{
    public function index()
    {
        $durezas = Dureza::all();

        if (!session('modal')) {
            session()->put('modal', 'create');
        }

        return view('produccion.actualizaciones.durezas.index', compact('durezas'));
    }

    public function create()
    {
        return view('produccion.actualizaciones.durezas.create');
    }

    public function store(StoreDurezaRequest $request)
    {
        
        $data = $request->all();

        $dureza = Dureza::create($data);
    
        return redirect()->route('durezas.index');
    }

    public function edit(Dureza $dureza)
    {
        return view('produccion.actualizaciones.durezas.edit', compact('dureza'));
    }

    public function update(UpdateDurezaRequest $request, Dureza $dureza)
    {
        $data = $request->all();

        $dureza->update($data);

        if ($data['Predeterminado'] == 1) {

            Dureza::where('id', '!=', $dureza->id)
                ->update(['Predeterminado' => 0]);
        }

        return redirect()->route('durezas.index');
    }


    public function destroy(Dureza $dureza)
    {
        $dureza->delete();
    
        return redirect()->route('durezas.index');
    }

}
