<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFactorPremioRequest;
use App\Models\FactorPremio;
use Illuminate\Http\Request;

class FactorPremioController extends Controller
{
    public function index()
    {
        $factores_premio = FactorPremio::all();

        return view('produccion.actualizaciones.factores-premio.index', compact('factores_premio'));
    }

    public function create()
    {
        return view('produccion.actualizaciones.factores-premio.create');
    }

    public function store(StoreFactorPremioRequest $request)
    {
        $data = $request->all();

        $factor_premio = FactorPremio::create($data);
    
        return redirect()->route('factores-premio.index');
    }

    public function edit(FactorPremio $factor_premio)
    {
        return view('produccion.actualizaciones.factores-premio.edit', compact('factor_premio'));
    }

    public function update(StoreFactorPremioRequest $request, FactorPremio $factor_premio)
    {
        $data = $request->all();

        $factor_premio->update($data);
    
        return redirect()->route('factores-premio.index');
    }

    public function destroy(FactorPremio $factor_premio)
    {
        $factor_premio->delete();
    
        return redirect()->route('factores-premio.index');
    }

}
