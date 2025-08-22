<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfiguracionGlobalRequest;
use App\Models\ConfiguracionGlobal;
use Illuminate\Http\Request;

class ConfiguracionGlobalController extends Controller
{
    public function edit()
    {
        $configuracion_global = ConfiguracionGlobal::first();

        return view('sistema.configuracion.configuracion-global.edit', compact('configuracion_global'));
    }

    public function update(StoreConfiguracionGlobalRequest $request, ConfiguracionGlobal $configuracion_global)
    {
        $data = $request->all();

        $configuracion_global->update($data);
    
        return redirect()->route('sistema.configuracion.configuracion-global.edit');
    }
}
