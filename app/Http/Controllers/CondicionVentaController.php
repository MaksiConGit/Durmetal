<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCondicionVentaRequest;
use App\Models\CondicionVenta;
use Illuminate\Http\Request;

class CondicionVentaController extends Controller
{
    public function index()
    {
        $condiciones_venta = CondicionVenta::all();

        return view('sistema.configuracion.condiciones-de-venta.index', compact('condiciones_venta'));
    }

    public function create()
    {
        return view('sistema.configuracion.condiciones-de-venta.create');
    }

    public function store(StoreCondicionVentaRequest $request)
    {
        $data = $request->all();

        CondicionVenta::create($data);
    
        return redirect()->route('sistema.configuracion.condiciones-de-venta.index');
    }

    public function edit(CondicionVenta $condicion_venta)
    {
        return view('sistema.configuracion.condiciones-de-venta.edit', compact('condicion_venta'));
    }

    public function update(StoreCondicionVentaRequest $request, CondicionVenta $condicion_venta)
    {
        $data = $request->all();

        $condicion_venta->update($data);
    
        return redirect()->route('sistema.configuracion.condiciones-de-venta.index');
    }

    public function destroy(CondicionVenta $condicion_venta)
    {
        $condicion_venta->delete();
    
        return redirect()->route('sistema.configuracion.condiciones-de-venta.index');
    }
}
